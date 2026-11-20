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
        Schema::create('package_booking_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('package_booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event', 32);
            $table->enum('from_status', array_map(
                fn (PackageBookingStatus $status): string => $status->value,
                PackageBookingStatus::cases(),
            ))->nullable();
            $table->enum('to_status', array_map(
                fn (PackageBookingStatus $status): string => $status->value,
                PackageBookingStatus::cases(),
            ));
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['package_booking_id', 'created_at']);
        });

        DB::table('package_bookings')
            ->orderBy('id')
            ->chunkById(500, function ($bookings): void {
                DB::table('package_booking_logs')->insert($bookings->map(fn ($booking): array => [
                    'package_booking_id' => $booking->id,
                    'user_id' => null,
                    'event' => 'history_initialized',
                    'from_status' => null,
                    'to_status' => $booking->status,
                    'note' => 'Activity history initialized for this booking.',
                    'created_at' => $booking->created_at,
                ])->all());
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_booking_logs');
    }
};
