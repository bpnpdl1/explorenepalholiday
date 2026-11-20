<?php

namespace App\Http\Requests;

use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePackageBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $package = $this->route('package');

        abort_unless($package instanceof Package && $package->is_published, 404);

        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        $package = $this->route('package');

        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'country_of_residence' => ['nullable', 'string', 'max:100'],
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'guests' => [
                'required',
                'integer',
                'min:'.max(1, (int) ($package->min_group_size ?: 1)),
                'max:'.max((int) ($package->min_group_size ?: 1), min(20, (int) ($package->max_group_size ?: 6))),
            ],
            'special_requests' => ['nullable', 'string', 'max:10000'],
            'consent' => ['accepted'],
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'customer_name' => 'full name',
            'country_of_residence' => 'country of residence',
            'travel_date' => 'preferred departure date',
            'guests' => 'number of travellers',
            'special_requests' => 'trip notes',
        ];
    }
}
