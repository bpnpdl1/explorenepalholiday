<?php

namespace App\Http\Requests\Admin;

use App\Enums\PackageBookingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePackageBookingStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(PackageBookingStatus::class)],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
