<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTravelInfoPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('travel_info_pages', 'slug')->ignore($this->route('travelInfoPage')),
            ],
            'content' => ['required', 'string', 'max:100000'],
            'sort_order' => ['required', 'integer', 'between:0,65535'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
