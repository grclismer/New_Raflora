<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'event_type' => ['required', 'string', 'in:wedding,birthday,corporate'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'venue' => ['required', 'string', 'max:500'],
            'special_requests' => ['nullable', 'string', 'max:2000'],
            'inspiration_image' => ['nullable', 'image', 'max:4096'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'event_type.required' => 'Please select the type of event.',
            'event_type.in' => 'Please choose a valid event type.',
            'event_date.required' => 'The event date is required.',
            'event_date.date' => 'The event date must be a valid date.',
            'event_date.after_or_equal' => 'The event date cannot be in the past.',
            'venue.required' => 'Event venue is required.',
            'venue.max' => 'The venue description may not exceed 500 characters.',
            'special_requests.max' => 'Special requests may not exceed 2000 characters.',
            'inspiration_image.image' => 'The inspiration file must be an image.',
            'inspiration_image.max' => 'The inspiration image may not exceed 4MB.',
        ];
    }
}
