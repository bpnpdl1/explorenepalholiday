<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

abstract class PackageReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'quote' => ['required', 'string', 'max:10000'],
            'reviewer_name' => ['nullable', 'string', 'max:255'],
            'reviewer_label' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'between:0,65535'],
        ];
    }
}
