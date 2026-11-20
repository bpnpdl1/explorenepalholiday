<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\TeamMembers\SaveTeamMemberAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        $teamMembers = TeamMember::query()
            ->with('media')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('bio', 'like', "%{$search}%");
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.team-members.index', [
            'teamMembers' => $teamMembers,
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'teamMemberCount' => TeamMember::count(),
            'publishedCount' => TeamMember::where('is_published', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team-members.create', ['teamMember' => new TeamMember]);
    }

    public function store(StoreTeamMemberRequest $request, SaveTeamMemberAction $saveTeamMember): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'role', 'bio', 'sort_order']);
        $saveTeamMember->handle($data, $request->boolean('is_published'), $request->file('portrait_image'));

        return to_route('admin.team-members.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $teamMember): View
    {
        $teamMember->load('media');

        return view('admin.team-members.edit', compact('teamMember'));
    }

    public function update(
        UpdateTeamMemberRequest $request,
        TeamMember $teamMember,
        SaveTeamMemberAction $saveTeamMember,
    ): RedirectResponse {
        $data = $request->safe()->only(['name', 'role', 'bio', 'sort_order']);
        $saveTeamMember->handle(
            $data,
            $request->boolean('is_published'),
            $request->file('portrait_image'),
            $request->boolean('remove_portrait'),
            $teamMember,
        );

        return to_route('admin.team-members.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->delete();

        return to_route('admin.team-members.index')
            ->with('success', 'Team member deleted successfully.');
    }
}
