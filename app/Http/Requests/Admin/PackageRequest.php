<?php

namespace App\Http\Requests\Admin;

use App\Enums\Season;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class PackageRequest extends FormRequest
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
        $seasons = array_map(fn (Season $season): string => $season->value, Season::cases());

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
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['required', 'string', 'max:50', 'distinct', Rule::in(['trekking', 'challenging', 'featured journey'])],
            'is_published' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['required', 'integer', 'between:0,65535'],
            'seasons' => ['nullable', 'array', 'max:4'],
            'seasons.*' => ['required', 'string', 'distinct', Rule::in($seasons)],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'gallery' => ['nullable', 'array', 'max:20'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer', 'exists:media,id'],
        ];
    }
}
