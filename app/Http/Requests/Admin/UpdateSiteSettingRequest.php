<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:2000'],
            'social_links' => ['nullable', 'array'],
            'social_links.facebook' => ['nullable', 'url', 'max:2048'],
            'social_links.instagram' => ['nullable', 'url', 'max:2048'],
            'social_links.tiktok' => ['nullable', 'url', 'max:2048'],
            'social_links.youtube' => ['nullable', 'url', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'canonical_url' => ['nullable', 'url', 'max:2048'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:1000'],
            'footer_resources_eyebrow' => ['required', 'string', 'max:100'],
            'footer_resources_title' => ['required', 'string', 'max:255'],
            'footer_resources_description' => ['required', 'string', 'max:1000'],
            'footer_resources' => ['required', 'array', 'min:1', 'max:12'],
            'footer_resources.*.name' => ['required', 'string', 'max:255'],
            'footer_resources.*.url' => [
                'required',
                'url',
                'max:2048',
                static function (string $attribute, mixed $value, \Closure $fail): void {
                    $scheme = is_string($value) ? parse_url($value, PHP_URL_SCHEME) : null;

                    if (! in_array($scheme, ['http', 'https'], true)) {
                        $fail('Use an HTTP or HTTPS organization website.');
                    }
                },
            ],
            'footer_resources.*.logo' => [
                'required',
                'string',
                'max:2048',
                static function (string $attribute, mixed $value, \Closure $fail): void {
                    $isLocalAsset = is_string($value) && str_starts_with($value, '/') && ! str_starts_with($value, '//');
                    $scheme = is_string($value) ? parse_url($value, PHP_URL_SCHEME) : null;

                    if (! $isLocalAsset && ! in_array($scheme, ['http', 'https'], true)) {
                        $fail('Use a local asset path or an HTTP or HTTPS image URL.');
                    }
                },
            ],
            'footer_resources.*.alt' => ['required', 'string', 'max:255'],
            'footer_payment_title' => ['required', 'string', 'max:100'],
            'footer_payment_description' => ['required', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'footer_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'footer_payment_options' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=4000,max_height=1000'],
            'favicon' => ['nullable', 'image', 'mimes:png', 'max:2048', 'dimensions:min_width=16,min_height=16,max_width=512,max_height=512'],
        ];
    }
}
