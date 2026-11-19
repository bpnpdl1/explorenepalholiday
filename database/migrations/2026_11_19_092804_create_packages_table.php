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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedSmallInteger('duration_days')->nullable();
            $table->unsignedSmallInteger('duration_nights')->nullable();
            $table->string('difficulty', 50)->nullable();
            $table->unsignedSmallInteger('max_altitude_meters')->nullable();
            $table->unsignedSmallInteger('min_group_size')->nullable();
            $table->unsignedSmallInteger('max_group_size')->nullable();
            $table->decimal('price_from', 10, 2)->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->char('currency', 3)->default('USD');
            $table->string('price_qualifier')->nullable();
            $table->string('route_map_url', 2048)->nullable();
            $table->text('accommodation')->nullable();
            $table->longText('fitness_guidance')->nullable();
            $table->longText('permit_notes')->nullable();
            $table->longText('safety_notes')->nullable();
            $table->longText('weather_notes')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['subcategory_id', 'is_published', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
