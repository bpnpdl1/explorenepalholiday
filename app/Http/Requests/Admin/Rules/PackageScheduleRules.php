<?php

namespace App\Http\Requests\Admin\Rules;

use App\Enums\Season;
use Illuminate\Validation\Rule;

class PackageScheduleRules
{
    /** @return array<string, array<int, mixed>> */
    public static function rules(): array
    {
        $seasons = array_map(fn (Season $season): string => $season->value, Season::cases());

        return [
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['required', 'string', 'max:50', 'distinct', Rule::in(['trekking', 'challenging', 'featured journey'])],
            'seasons' => ['nullable', 'array', 'max:4'],
            'seasons.*' => ['required', 'string', 'distinct', Rule::in($seasons)],
        ];
    }
}
