<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestReviewRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reviewer_name' => ['required', 'string', 'max:255'],
            'reviewer_initials' => ['nullable', 'string', 'max:10'],
            'trip_name' => ['nullable', 'string', 'max:255'],
            'region_name' => ['nullable', 'string', 'max:255'],
            'review_text' => ['required', 'string', 'max:100000'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'reviewed_at' => ['nullable', 'date'],
            'source_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
