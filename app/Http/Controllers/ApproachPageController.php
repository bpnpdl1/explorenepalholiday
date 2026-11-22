<?php

namespace App\Http\Controllers;

use App\Models\ApproachPage;
use Illuminate\Contracts\View\View;

class ApproachPageController extends Controller
{
    public function __invoke(): View
    {
        $approachPage = ApproachPage::query()->findOrFail(ApproachPage::SINGLETON_ID);

        return view('site.approach', compact('approachPage'));
    }
}
