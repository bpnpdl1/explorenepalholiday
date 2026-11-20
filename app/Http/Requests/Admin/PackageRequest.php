<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Rules\PackageContentRules;
use App\Http\Requests\Admin\Rules\PackageDetailsRules;
use App\Http\Requests\Admin\Rules\PackageMediaRules;
use App\Http\Requests\Admin\Rules\PackageScheduleRules;
use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;

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
        $package = $this->route('package');
        $packageId = $package instanceof Package ? $package->id : null;

        return [
            ...PackageDetailsRules::rules(),
            ...PackageScheduleRules::rules(),
            ...PackageContentRules::rules($packageId),
            ...PackageMediaRules::rules(),
        ];
    }
}
