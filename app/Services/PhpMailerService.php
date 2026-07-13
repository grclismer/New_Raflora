<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMailerService
{
    protected PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // SMTP settings from env
        $this->mailer->isSMTP();
        $this->mailer->Host = env('MAIL_HOST', '127.0.0.1');
        $this->mailer->Port = env('MAIL_PORT', 1025);
        $this->mailer->SMTPAuth = (bool) env('MAIL_USERNAME');
        $this->mailer->Username = env('MAIL_USERNAME');
        $this->mailer->Password = env('MAIL_PASSWORD_RESET', env('MAIL_PASSWORD'));
        $encryption = env('MAIL_ENCRYPTION');
        if ($encryption && in_array(strtolower($encryption), ['ssl','tls'])) {
            $this->mailer->SMTPSecure = $encryption;
        }

        $this->mailer->setFrom(env('MAIL_FROM_ADDRESS', 'no-reply@example.com'), env('MAIL_FROM_NAME', 'App'));
        $this->mailer->isHTML(true);
    }

    /**
     * Send a password reset email with a nice HTML template.
     *
     * This method is used by the custom AuthController reset flow so that the
     * app can send a Gmail/PHPMailer email with a branded button and expiry note.
     *
     * @param string $toEmail
     * @param string|null $toName
     * @param string $resetUrl
     * @return bool
     */
    public function sendPasswordReset(string $toEmail, ?string $toName, string $resetUrl): bool
    {
        try {
            $this->mailer->clearAllRecipients();
            $this->mailer->addAddress($toEmail, $toName ?? '');

            $subject = env('APP_NAME', 'Application') . ' — Account Recovery';
            $this->mailer->Subject = $subject;

            $html = $this->buildResetHtml($toName ?? $toEmail, $resetUrl);

            $this->mailer->Body = $html;
            $this->mailer->AltBody = "Reset your password: $resetUrl";

            return $this->mailer->send();
        } catch (Exception $e) {
            \Log::error('PHPMailer error: ' . $e->getMessage());
            return false;
        }
    }

    protected function buildResetHtml(string $name, string $resetUrl): string
    {
        $appName = env('APP_NAME', 'Application');
        $buttonColor = '#4F46E5';
        $expireMinutes = config('auth.passwords.users.expire', 60);
        return <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Password Reset</title>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;background:#f6f8fb;margin:0;padding:0;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;margin:40px 0;border-radius:8px;overflow:hidden;">
          <tr>
            <td style="padding:28px;text-align:center;background:#eef2ff;">
              <h1 style="margin:0;color:#111827;">$appName</h1>
              <p style="margin:6px 0 0;color:#6b7280;">Account Recovery Required</p>
            </td>
          </tr>
          <tr>
            <td style="padding:32px;color:#374151;">
              <p>Hello <strong>$name</strong>,</p>
              <p>Your account recovery request was received. Click the button below to set a new password.</p>
              <p style="text-align:center;margin:28px 0;">
                <a href="$resetUrl" style="background:$buttonColor;color:#fff;padding:12px 20px;border-radius:6px;text-decoration:none;display:inline-block;font-weight:600;">Recover My Account</a>
              </p>
              <p style="margin-top:6px;color:#6b7280;font-size:14px;">Important: This link is valid for $expireMinutes minutes and must be used before it expires.</p>
              <p>If the button doesn't work, copy and paste the link below into your browser:</p>
              <p style="word-break:break-all;color:#6b7280;">$resetUrl</p>
              <p style="margin-top:16px;color:#9ca3af;font-size:13px;">If you didn't request this, you can safely ignore this email.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:16px;text-align:center;background:#f3f4f6;color:#9ca3af;font-size:12px;">$appName</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
    }
}
