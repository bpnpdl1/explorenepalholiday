<?php

namespace App\Http\Controllers;

use App\Actions\Site\BuildSubcategoryPageDataAction;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;

class SubcategoryController extends Controller
{
    public function show(Subcategory $subcategory, BuildSubcategoryPageDataAction $buildPageData): View
    {
        return view('site.subcategories.show', $buildPageData->handle($subcategory));
    }
}
