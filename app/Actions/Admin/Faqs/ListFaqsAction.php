<?php

namespace App\Actions\Admin\Faqs;

use App\Models\Faq;
use Illuminate\Http\Request;

class ListFaqsAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        return [
            'faqs' => Faq::query()
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($query) use ($search): void {
                        $query->where('question', 'like', "%{$search}%")
                            ->orWhere('answer', 'like', "%{$search}%");
                    });
                })
                ->when($status === 'published', fn ($query) => $query->where('is_published', true))
                ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
                ->orderBy('sort_order')
                ->orderBy('question')
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'faqCount' => Faq::query()->count(),
            'publishedCount' => Faq::query()->where('is_published', true)->count(),
        ];
    }
}
