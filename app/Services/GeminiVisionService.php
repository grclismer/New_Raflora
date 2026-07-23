<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiVisionService
{
    /**
     * Ordered free-tier fallback models.
     * @var string[]
     */
    protected array $fallbackModels = [
        'gemini-3.5-flash',
        'gemini-3.1-flash-lite',
        'gemini-2.5-flash',
        'gemini-2.5-flash-lite',
        'gemini-1.5-flash',
    ];

    protected string $apiUrl;
    protected ?string $apiKey;

    public function __construct()
    {
        // Base URL is built per-model when calling the Google Gemini REST endpoint.
        $this->apiUrl = env('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models');
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Analyze an image file path and return parsed JSON and model used.
     * @param string $filePath Local filesystem path to image
     * @return array ['model_used'=>string, 'analysis'=>array, 'raw_response'=>string]
     * @throws \Exception
     */
    public function analyzeImageFromPath(string $filePath, ?string $specialRequests = null, ?string $eventType = null, ?string $eventTime = null, ?string $venue = null): array
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: {$filePath}");
        }

        $systemPrompt = <<<'PROMPT'
You are a senior floral appraiser specializing in the wholesale and retail flower markets of Metro Manila, Philippines (specifically Dangwa Flower Market).
Inspect user-uploaded images of flower arrangements or perishable floral items, identify the components, estimate standard Philippine Peso (PHP / ₱) market prices, and return ONLY a structured JSON response.

GUIDELINES:
1. Identify dominant flower varieties, filler flora, and packaging materials.
2. Assess visual condition (Fresh / Grade A, Standard, or Low Quality).
3. Provide realistic estimated quantities and prices in Philippine Pesos (PHP / ₱). Use realistic wholesale floor prices for flowers in the Dangwa/local market context.
4. Output raw baseline market costs ONLY. Do NOT apply labor, setup, or 3x markup in the item prices (the backend handles the 3x pricing rule).
5. Use only what is visible in the image and context; avoid hallucinations.
6. Return JSON ONLY. Do not include markdown wrappers, explanation text, or extra fields.

REQUIRED JSON SCHEMA:
{
  "suggested_materials": [
    {
      "item_name": "string",
      "estimated_quantity": number,
      "unit_type": "stem",
      "estimated_unit_cost_php": number
    }
  ]
}
PROMPT;

        if (!empty($eventType) || !empty($eventTime) || !empty($venue) || !empty($specialRequests)) {
            $systemPrompt .= "\n\nContext:";
            if (!empty($eventType)) {
                $systemPrompt .= "\n- Event Type: " . trim($eventType);
            }
            if (!empty($eventTime)) {
                $systemPrompt .= "\n- Event Time: " . trim($eventTime);
            }
            if (!empty($venue)) {
                $systemPrompt .= "\n- Venue: " . trim($venue);
            }
            if (!empty($specialRequests)) {
                $systemPrompt .= "\n- Special Requests: " . trim($specialRequests);
            }
        }

        $preparedImage = $this->prepareImageForGemini($filePath);
        if (is_array($preparedImage)) {
            $mimeType = $preparedImage['mime_type'];
            $base64 = $preparedImage['data'];
            $tempFilePath = null;
        } else {
            $tempFilePath = $preparedImage;
            $fileContents = file_get_contents($tempFilePath);
            $base64 = base64_encode($fileContents);
            $mimeType = mime_content_type($tempFilePath) ?: 'image/jpeg';
        }

        $lastException = null;

        foreach ($this->fallbackModels as $model) {
            try {
                // Build Google Gemini v1beta endpoint for the specific model and include API key in query
                if (empty($this->apiKey)) {
                    throw new \Exception('GEMINI_API_KEY is not configured in environment.');
                }

                $endpoint = rtrim($this->apiUrl, '/') . "/{$model}:generateContent?key=" . urlencode($this->apiKey);

                $payload = [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data'      => $base64,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'responseMimeType' => 'application/json',
                    ],
                ];

                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->timeout(12)->connectTimeout(5)->post($endpoint, $payload);

                $status = $response->status();

                // Detect quota / rate limit
                $body = $response->body();

                // Detect quota / rate limit or temporary unavailability by status or response content
                if ($status === 429 || $status === 503 || stripos($body, 'RESOURCE_EXHAUSTED') !== false || stripos($body, 'UNAVAILABLE') !== false || stripos($body, 'quota') !== false) {
                    Log::warning("Quota reached for {$model}. Failing over to next model.");
                    continue; // try next model
                }

                if ($status === 404) {
                    Log::warning("Gemini model {$model} not found or unavailable; trying next model.", [
                        'status' => $status,
                        'body' => $body,
                    ]);
                    continue;
                }

                if ($status >= 400) {
                    // Non-quota client/server error — bail out
                    throw new \Exception("Gemini API error (model={$model}) status={$status}: {$body}");
                }

                $responseData = $response->json();

                // Prefer the first candidate part text when available.
                $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if (is_string($generatedText)) {
                    $generatedText = trim($generatedText);
                }

                if (empty($generatedText)) {
                    // Fallback to scanning all candidate parts for JSON.
                    $candidateContent = $responseData['candidates'][0]['content'] ?? [];
                    $candidateParts = [];

                    if (is_array($candidateContent)) {
                        foreach ($candidateContent as $contentSegment) {
                            if (is_array($contentSegment) && isset($contentSegment['parts']) && is_array($contentSegment['parts'])) {
                                $candidateParts = array_merge($candidateParts, $contentSegment['parts']);
                            } elseif (is_array($contentSegment) && isset($contentSegment['text'])) {
                                $candidateParts[] = $contentSegment;
                            } elseif (is_string($contentSegment)) {
                                $candidateParts[] = ['text' => $contentSegment];
                            }
                        }
                    }

                    if (empty($candidateParts) && is_string($candidateContent)) {
                        $candidateParts[] = ['text' => $candidateContent];
                    }

                    $allText = [];
                    foreach ($candidateParts as $part) {
                        if (is_array($part) && isset($part['text']) && is_string($part['text'])) {
                            $text = trim($part['text']);
                            if ($text !== '') {
                                $allText[] = $text;
                            }
                            if ($this->extractFirstJson($text) !== null) {
                                $generatedText = $text;
                                break;
                            }
                        }
                    }

                    if ($generatedText === null && !empty($allText)) {
                        $generatedText = implode("\n", $allText);
                    }
                }

                if (empty($generatedText)) {
                    throw new \Exception("Gemini response missing generated text (model={$model}). Raw: {$body}");
                }

                $parsed = $this->extractFirstJson($generatedText);
                if ($parsed === null) {
                    throw new \Exception("Generated content did not contain valid JSON (model={$model}). Raw generated: {$generatedText}");
                }

                return [
                    'model_used' => $model,
                    'analysis' => $parsed,
                    'raw_response' => $body,
                ];
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                $lastException = $e;
                Log::warning('GeminiVisionService connection timeout or network issue.', [
                    'message' => $e->getMessage(),
                    'model' => $model,
                    'file' => $filePath,
                ]);

                continue; // Move to the next fallback model
            } catch (\Exception $e) {
                $lastException = $e;
                Log::error('GeminiVisionService analyzeImageFromPath failed.', [
                    'message' => $e->getMessage(),
                    'model' => $model,
                    'file' => $filePath,
                    'throwable' => $e,
                ]);

                // If exception message indicates quota or temporary capacity, continue; else rethrow
                $msg = $e->getMessage();
                if (stripos($msg, 'RESOURCE_EXHAUSTED') !== false || stripos($msg, 'UNAVAILABLE') !== false || stripos($msg, 'quota') !== false || stripos($msg, '429') !== false || stripos($msg, '503') !== false) {
                    Log::warning("Quota/limit detected for {$model}: {$msg}. Failing over to next model.");
                    continue;
                }

                throw $e;
            } finally {
                if (isset($tempFilePath) && file_exists($tempFilePath) && $tempFilePath !== $filePath) {
                    @unlink($tempFilePath);
                }
            }
        }

        if (isset($tempFilePath) && file_exists($tempFilePath) && $tempFilePath !== $filePath) {
            @unlink($tempFilePath);
        }

        Log::warning('All Gemini fallback models failed; applying default analysis fallback.', [
            'last_exception' => $lastException?->getMessage(),
            'file' => $filePath,
        ]);

        return [
            'model_used' => null,
            'analysis' => [
                'suggested_materials' => [
                    [
                        'item_name' => 'Assorted Event Floral & Arrangement Set',
                        'estimated_quantity' => 1,
                        'unit_type' => 'set',
                        'estimated_unit_cost_php' => 3500,
                    ],
                ],
                'analysis_notes' => 'Default pricing estimation applied.',
            ],
            'raw_response' => $lastException?->getMessage() ?? 'All models failed.',
        ];
    }

    /**
     * Prepare an image for Gemini by resizing and encoding to optimized JPEG.
     * @param string $filePath
     * @return string Temporary JPEG file path
     * @throws \Exception
     */
    protected function prepareImageForGemini(string $filePath): array|string
    {
        if (!function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng') || !function_exists('imagecreatetruecolor') || !function_exists('imagejpeg')) {
            return [
                'mime_type' => mime_content_type($filePath) ?: 'image/jpeg',
                'data' => base64_encode(file_get_contents($filePath)),
            ];
        }

        $info = getimagesize($filePath);
        if ($info === false) {
            throw new \Exception('Unsupported image format for Gemini upload.');
        }

        [$width, $height, $type] = $info;
        $maxDimension = 1024;
        $ratio = min(1, $maxDimension / $width, $maxDimension / $height);
        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($filePath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($filePath);
                break;
            case IMAGETYPE_BMP:
                $source = imagecreatefrombmp($filePath);
                break;
            default:
                throw new \Exception('Unsupported image type for Gemini upload.');
        }

        if ($source === false) {
            throw new \Exception('Failed to read source image for resizing.');
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        if ($resized === false) {
            imagedestroy($source);
            throw new \Exception('Failed to create resized image canvas.');
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $tempFile = tempnam(sys_get_temp_dir(), 'gemini_img_');
        if ($tempFile === false) {
            imagedestroy($source);
            imagedestroy($resized);
            throw new \Exception('Unable to create temporary file for Gemini upload.');
        }

        if (!imagejpeg($resized, $tempFile, 80)) {
            imagedestroy($source);
            imagedestroy($resized);
            @unlink($tempFile);
            throw new \Exception('Failed to write resized JPEG image for Gemini upload.');
        }

        imagedestroy($source);
        imagedestroy($resized);

        return $tempFile;
    }

    /**
     * Try to extract the first JSON object or array from a string.
     * @param string $text
     * @return array|null
     */
    protected function extractFirstJson(string $text): ?array
    {
        // Attempt pure json decode first
        $clean = trim($text);
        $decoded = json_decode($clean, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Find first JSON object or array using regex
        if (preg_match('/(\{.*\}|\[.*\])/s', $text, $m)) {
            $candidate = $m[0];
            $decoded = json_decode($candidate, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }
}
