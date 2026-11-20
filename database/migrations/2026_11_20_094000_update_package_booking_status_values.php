<?php

use App\Enums\PackageBookingStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_bookings', function (Blueprint $table): void {
            $table->enum('status', [
                'new_inquiry',
                'pending_review',
                'awaiting_payment',
                'confirmed',
                'completed',
                'cancelled',
                ...array_map(
                    fn (PackageBookingStatus $status): string => $status->value,
                    PackageBookingStatus::cases(),
                ),
            ])->default('new_inquiry')->change();
        });

        DB::table('package_bookings')->where('status', 'new_inquiry')->update(['status' => 'new']);
        DB::table('package_bookings')
            ->whereIn('status', ['pending_review', 'awaiting_payment'])
            ->update(['status' => 'processing']);
        DB::table('package_bookings')->where('status', 'cancelled')->update(['status' => 'canceled']);
        DB::table('package_bookings')->where('status', 'completed')->update(['status' => 'confirmed']);

        Schema::table('package_bookings', function (Blueprint $table): void {
            $table->enum('status', array_map(
                fn (PackageBookingStatus $status): string => $status->value,
                PackageBookingStatus::cases(),
            ))->default(PackageBookingStatus::New->value)->change();
        });
    }

    public function down(): void
    {
        Schema::table('package_bookings', function (Blueprint $table): void {
            $table->enum('status', [
                'new_inquiry',
                'pending_review',
                'awaiting_payment',
                'confirmed',
                'completed',
                'cancelled',
                ...array_map(
                    fn (PackageBookingStatus $status): string => $status->value,
                    PackageBookingStatus::cases(),
                ),
            ])->default(PackageBookingStatus::New->value)->change();
        });

        DB::table('package_bookings')->where('status', 'new')->update(['status' => 'new_inquiry']);
        DB::table('package_bookings')->where('status', 'processing')->update(['status' => 'pending_review']);
        DB::table('package_bookings')->where('status', 'canceled')->update(['status' => 'cancelled']);

        Schema::table('package_bookings', function (Blueprint $table): void {
            $table->enum('status', [
                'new_inquiry',
                'pending_review',
                'awaiting_payment',
                'confirmed',
                'completed',
                'cancelled',
            ])->default('new_inquiry')->change();
        });
    }
};
