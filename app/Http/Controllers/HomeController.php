<?php

namespace App\Http\Controllers;

use App\Actions\Site\BuildHomePageDataAction;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(BuildHomePageDataAction $buildHomePageData): View
    {
        return view('site.home', $buildHomePageData->handle());
    }
}
