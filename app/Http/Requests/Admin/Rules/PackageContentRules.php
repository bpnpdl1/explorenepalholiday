<?php

namespace App\Http\Requests\Admin\Rules;

use Illuminate\Validation\Rule;

class PackageContentRules
{
    /** @return array<string, array<int, mixed>> */
    public static function rules(?int $packageId): array
    {
        $packageId ??= 0;

        return [
            'included_features' => ['nullable', 'array', 'max:100'],
            'included_features.*' => ['required', 'array:id,description'],
            'included_features.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('package_features', 'id')->where('package_id', $packageId)->where('type', 'included'),
            ],
            'included_features.*.description' => ['required', 'string', 'max:5000'],
            'excluded_features' => ['nullable', 'array', 'max:100'],
            'excluded_features.*' => ['required', 'array:id,description'],
            'excluded_features.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('package_features', 'id')->where('package_id', $packageId)->where('type', 'excluded'),
            ],
            'excluded_features.*.description' => ['required', 'string', 'max:5000'],
            'itinerary_days' => ['nullable', 'array', 'max:100'],
            'itinerary_days.*' => ['required', 'array:id,title,location,altitude_meters,activity_label,meal_plan,description'],
            'itinerary_days.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('package_itinerary_days', 'id')->where('package_id', $packageId),
            ],
            'itinerary_days.*.title' => ['required', 'string', 'max:255'],
            'itinerary_days.*.location' => ['nullable', 'string', 'max:255'],
            'itinerary_days.*.altitude_meters' => ['nullable', 'integer', 'between:0,65535'],
            'itinerary_days.*.activity_label' => ['nullable', 'string', 'max:255'],
            'itinerary_days.*.meal_plan' => ['nullable', 'string', 'max:255'],
            'itinerary_days.*.description' => ['nullable', 'string', 'max:100000'],
            'elevation_points' => ['nullable', 'array', 'max:100'],
            'elevation_points.*' => ['required', 'array:id,stop_name,altitude_meters'],
            'elevation_points.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('package_elevation_points', 'id')->where('package_id', $packageId),
            ],
            'elevation_points.*.stop_name' => ['required', 'string', 'max:255'],
            'elevation_points.*.altitude_meters' => ['required', 'integer', 'between:0,65535'],
            'faqs' => ['nullable', 'array', 'max:100'],
            'faqs.*' => ['required', 'array:id,question,answer'],
            'faqs.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('package_faqs', 'id')->where('package_id', $packageId),
            ],
            'faqs.*.question' => ['required', 'string', 'max:500'],
            'faqs.*.answer' => ['required', 'string', 'max:10000'],
        ];
    }
}
