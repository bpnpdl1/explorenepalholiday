<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Users\ListUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request, ListUsersAction $listUsers): View
    {
        return view('admin.users.index', $listUsers->handle($request));
    }

    public function create(): View
    {
        return view('admin.users.create', ['user' => new User]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = new User;
        $user->name = $data['name'];
        $user->email = Str::lower($data['email']);
        $user->password = $data['password'];
        $user->is_admin = (bool) $data['is_admin'];
        $user->email_verified_at = (bool) $data['email_verified'] ? now() : null;
        $user->save();

        return to_route('admin.users.index')
            ->with('success', 'User account created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if ($request->user()->is($user)) {
            if (! (bool) $data['is_admin']) {
                return back()->withInput()->with('error', 'You cannot remove your own administrator access.');
            }

            if (Str::lower($data['email']) !== Str::lower($user->email)) {
                return back()->withInput()->with('error', 'Ask another administrator to change your email address.');
            }

            if ((bool) $data['email_verified'] !== ($user->email_verified_at !== null)) {
                return back()->withInput()->with('error', 'Ask another administrator to change your email verification status.');
            }
        }

        $updated = DB::transaction(function () use ($data, $user): bool {
            $admins = User::query()
                ->where('is_admin', true)
                ->orderBy('id')
                ->lockForUpdate()
                ->get(['id']);
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->id);

            if ($lockedUser->is_admin && ! (bool) $data['is_admin'] && $admins->count() <= 1) {
                return false;
            }

            $lockedUser->name = $data['name'];
            $emailChanged = Str::lower($lockedUser->email) !== Str::lower($data['email']);
            $lockedUser->email = Str::lower($data['email']);
            $lockedUser->is_admin = (bool) $data['is_admin'];
            $lockedUser->email_verified_at = $emailChanged
                ? null
                : ((bool) $data['email_verified'] ? ($lockedUser->email_verified_at ?? now()) : null);

            if (filled($data['password'] ?? null)) {
                $lockedUser->password = $data['password'];
            }

            $lockedUser->save();

            return true;
        });

        if (! $updated) {
            return back()->withInput()->with('error', 'The last administrator must remain an administrator.');
        }

        return to_route('admin.users.index')
            ->with('success', 'User account updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return to_route('admin.users.index')
                ->with('error', 'You cannot delete your own account while signed in.');
        }

        $deleted = DB::transaction(function () use ($user): bool {
            $admins = User::query()
                ->where('is_admin', true)
                ->orderBy('id')
                ->lockForUpdate()
                ->get(['id']);
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->id);

            if ($lockedUser->is_admin && $admins->count() <= 1) {
                return false;
            }

            $lockedUser->delete();

            return true;
        });

        if (! $deleted) {
            return to_route('admin.users.index')
                ->with('error', 'The last administrator cannot be deleted.');
        }

        return to_route('admin.users.index')
            ->with('success', 'User account deleted successfully.');
    }
}
