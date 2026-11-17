<?php

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
        Schema::create('guest_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name');
            $table->string('reviewer_initials', 10)->nullable();
            $table->string('trip_name')->nullable();
            $table->string('region_name')->nullable();
            $table->longText('review_text');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->date('reviewed_at')->nullable();
            $table->text('source_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_reviews');
    }
};
