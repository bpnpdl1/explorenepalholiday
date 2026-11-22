<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Rules\PackageContentRules;
use App\Http\Requests\Admin\Rules\PackageDetailsRules;
use App\Http\Requests\Admin\Rules\PackageMediaRules;
use App\Http\Requests\Admin\Rules\PackageScheduleRules;
use App\Models\Package;
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
        $package = $this->route('package');
        $packageId = $package instanceof Package ? $package->id : null;

        return [
            ...PackageDetailsRules::rules(),
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('destination_id', $this->integer('destination_id')),
            ],
            'subcategory_id' => [
                'required',
                'integer',
                Rule::exists('subcategories', 'id')->where('category_id', $this->integer('category_id')),
            ],
            ...PackageScheduleRules::rules(),
            ...PackageContentRules::rules($packageId),
            ...PackageMediaRules::rules(),
        ];
    }
}
