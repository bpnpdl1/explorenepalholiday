<?php

namespace App\Http\Requests\Admin;

use App\Enums\Season;
use Illuminate\Validation\Rule;

class StorePackageDepartureRequest extends PackageDepartureRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'season' => ['required', 'string', Rule::enum(Season::class)],
            'departures' => ['required', 'array', 'min:1', 'max:100'],
            'departures.*' => ['required', 'array:starts_on,ends_on,price'],
            'departures.*.starts_on' => ['required', 'date'],
            'departures.*.ends_on' => ['nullable', 'date', 'after_or_equal:departures.*.starts_on'],
            'departures.*.price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
