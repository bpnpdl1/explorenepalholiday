<?php

use App\Models\User;

test('authenticated non-admin users cannot access the admin panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

test('administrators can access protected admin pages', function () {
    $user = User::factory()->create();
    $user->forceFill(['is_admin' => true])->save();

    $this->actingAs($user)
        ->get(route('admin.users.index'))
        ->assertOk();
});
