<?php

namespace App\Http\Requests\Admin\Rules;

class PackageDetailsRules
{
    /** @return array<string, array<int, mixed>> */
    public static function rules(): array
    {
        return [
            'subcategory_id' => ['required', 'integer', 'exists:subcategories,id'],
            'name' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'description' => ['nullable', 'string', 'max:100000'],
            'duration_days' => ['nullable', 'integer', 'between:1,65535'],
            'duration_nights' => ['nullable', 'integer', 'between:0,65535'],
            'difficulty' => ['nullable', 'string', 'max:50'],
            'max_altitude_meters' => ['nullable', 'integer', 'between:0,65535'],
            'min_group_size' => ['nullable', 'integer', 'between:1,65535'],
            'max_group_size' => ['nullable', 'integer', 'between:1,65535', 'gte:min_group_size'],
            'price_from' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99', 'gte:price_from'],
            'currency' => ['required', 'string', 'size:3', 'regex:/^[A-Z]{3}$/'],
            'price_qualifier' => ['nullable', 'string', 'max:255'],
            'route_map_url' => ['nullable', 'url', 'max:2048'],
            'accommodation' => ['nullable', 'string', 'max:10000'],
            'fitness_guidance' => ['nullable', 'string', 'max:20000'],
            'permit_notes' => ['nullable', 'string', 'max:20000'],
            'safety_notes' => ['nullable', 'string', 'max:20000'],
            'weather_notes' => ['nullable', 'string', 'max:20000'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['required', 'integer', 'between:0,65535'],
        ];
    }
}
