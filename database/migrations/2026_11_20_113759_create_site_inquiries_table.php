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
        Schema::create('site_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('interest')->nullable();
            $table->longText('message')->nullable();
            $table->enum('status', array_map(
                fn (PackageInquiryStatus $status): string => $status->value,
                PackageInquiryStatus::cases(),
            ))->default(PackageInquiryStatus::New->value);
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_inquiries');
    }
};
