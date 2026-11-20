<?php

namespace App\Actions\Admin\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListUsersAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = $request->string('search')->trim()->toString();
        $role = $request->string('role')->toString();

        if (! in_array($role, ['admin', 'traveler'], true)) {
            $role = '';
        }

        return [
            'users' => User::query()
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
                ->withQueryString(),
            'search' => $search,
            'role' => $role,
            'userCount' => User::query()->count(),
            'adminCount' => User::query()->where('is_admin', true)->count(),
            'verifiedCount' => User::query()->whereNotNull('email_verified_at')->count(),
        ];
    }
}
