<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Contracts\View\View;

class TeamPageController extends Controller
{
    public function __invoke(): View
    {
        $teamMembers = TeamMember::query()
            ->where('is_published', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('site.team', compact('teamMembers'));
    }
}
