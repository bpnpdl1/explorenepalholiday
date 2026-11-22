<?php

namespace App\Http\Controllers;

use App\Enums\FaqCategory;
use App\Models\Faq;
use Illuminate\Contracts\View\View;

class FaqPageController extends Controller
{
    public function __invoke(): View
    {
        $publishedFaqs = Faq::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $faqsByCategory = $publishedFaqs->groupBy(fn (Faq $faq): string => $faq->categoryEnum()->value);

        $faqGroups = collect(FaqCategory::cases())
            ->map(fn (FaqCategory $category): array => [
                'category' => $category,
                'faqs' => $faqsByCategory->get($category->value, collect()),
            ])
            ->filter(fn (array $group): bool => $group['faqs']->isNotEmpty())
            ->values();

        $faqSchema = $publishedFaqs
            ->map(fn (Faq $faq): array => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->answer,
                ],
            ])
            ->all();

        return view('site.faq', compact('faqGroups', 'faqSchema'));
    }
}
