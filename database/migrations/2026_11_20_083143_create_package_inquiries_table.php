<?php

use App\Enums\PackageInquiryStatus;
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
        Schema::create('package_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone', 40);
            $table->string('travel_window')->nullable();
            $table->longText('message')->nullable();
            $table->enum('status', array_map(
                fn (PackageInquiryStatus $status): string => $status->value,
                PackageInquiryStatus::cases(),
            ))->default(PackageInquiryStatus::New->value);
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['package_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_inquiries');
    }
};
