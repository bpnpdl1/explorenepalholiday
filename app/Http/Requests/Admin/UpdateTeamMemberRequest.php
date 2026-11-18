<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamMemberRequest extends FormRequest
{
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
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'between:0,65535'],
            'is_published' => ['sometimes', 'boolean'],
            'portrait_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'remove_portrait' => ['sometimes', 'boolean'],
        ];
    }
}
