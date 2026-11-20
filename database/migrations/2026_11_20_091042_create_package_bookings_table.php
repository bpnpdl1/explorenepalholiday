<?php

use App\Enums\PackageBookingStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 32)->nullable()->unique();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_departure_id')->nullable()->constrained('package_departures')->nullOnDelete();
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone', 40);
            $table->string('country_of_residence', 100)->nullable();
            $table->date('travel_date');
            $table->unsignedSmallInteger('guests')->default(1);
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->char('currency', 3)->default('USD');
            $table->enum('status', array_map(
                fn (PackageBookingStatus $status): string => $status->value,
                PackageBookingStatus::cases(),
            ))->default(PackageBookingStatus::New->value);
            $table->longText('special_requests')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['package_id', 'travel_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }
};
