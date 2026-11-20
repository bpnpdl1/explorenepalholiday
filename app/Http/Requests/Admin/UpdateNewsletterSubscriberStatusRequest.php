<?php

namespace App\Http\Requests\Admin;

use App\Enums\NewsletterSubscriberStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsletterSubscriberStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(NewsletterSubscriberStatus::class)],
        ];
    }
}
