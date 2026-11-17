<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $role = $request->string('role')->toString();

        if (! in_array($role, ['admin', 'traveler'], true)) {
            $role = '';
        }

        $users = User::query()
            ->select(['id', 'name', 'email', 'email_verified_at', 'is_admin', 'created_at'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($role !== '', fn (Builder $query): Builder => $query->where('is_admin', $role === 'admin'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'userCount' => User::count(),
            'adminCount' => User::where('is_admin', true)->count(),
            'verifiedCount' => User::whereNotNull('email_verified_at')->count(),
        ]);
    }
}
