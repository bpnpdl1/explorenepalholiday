<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreSiteInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $countryCode = trim((string) $this->input('country_code'));
        $phone = trim((string) $this->input('phone'));

        $this->merge([
            'name' => $this->input('name', $this->input('full_name')),
            'phone' => Str::of($countryCode.' '.$phone)->trim()->replaceMatches('/\s+/', ' ')->toString(),
        ]);
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'country_code' => ['nullable', 'string', 'regex:/^\+[0-9]{1,4}$/'],
            'interest' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:10000'],
            'source' => ['required', Rule::in(['contact', 'home'])],
        ];
    }
}
