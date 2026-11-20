<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Faqs\ListFaqsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFaqRequest;
use App\Http\Requests\Admin\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request, ListFaqsAction $listFaqs): View
    {
        return view('admin.faqs.index', $listFaqs->handle($request));
    }

    public function create(): View
    {
        return view('admin.faqs.create', ['faq' => new Faq]);
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['question', 'answer', 'sort_order']);
        $data['is_published'] = $request->boolean('is_published');

        Faq::create($data);

        return to_route('admin.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->safe()->only(['question', 'answer', 'sort_order']);
        $data['is_published'] = $request->boolean('is_published');
        $faq->update($data);

        return to_route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return to_route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }
}
