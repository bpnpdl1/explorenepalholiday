<?php

namespace App\Http\Controllers;

use App\Actions\Site\ListPublishedPackagesAction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PackageListingController extends Controller
{
    public function __invoke(Request $request, ListPublishedPackagesAction $listPackages): View
    {
        return view('site.packages.index', $listPackages->handle($request));
    }
}
