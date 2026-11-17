<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) || blank($password)) {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before running the admin seeder.');
        }

        $admin = User::firstOrNew(['email' => Str::lower(trim($email))]);

        $admin->forceFill([
            'name' => config('admin.name', 'Administrator'),
            'password' => $password,
            'email_verified_at' => $admin->email_verified_at ?? now(),
            'is_admin' => true,
        ])->save();
    }
}
