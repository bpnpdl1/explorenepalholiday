<?php

namespace App\Http\Requests;

use App\Enums\Season;
use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePackageInquiryRequest extends FormRequest
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
        $package = $this->route('package');
        $validTravelWindows = $package instanceof Package
            ? $this->travelWindowOptions($package)
            : [];

        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'travel_window' => ['required', 'string', Rule::in($validTravelWindows)],
            'message' => ['nullable', 'string', 'max:10000'],
        ];
    }

    /**
     * @return list<string>
     */
    private function travelWindowOptions(Package $package): array
    {
        $departures = $package->departures()
            ->pluck('id')
            ->map(fn ($id): string => 'departure-'.$id);

        $seasons = $departures->isNotEmpty()
            ? collect()
            : $package->seasons()
                ->pluck('season')
                ->map(fn (Season $season): string => 'season-'.$season->value);

        return $departures
            ->concat($seasons)
            ->push('flexible')
            ->all();
    }
}
