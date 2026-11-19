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
        Schema::create('package_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->enum('season', ['autumn', 'spring', 'winter', 'monsoon']);
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->char('currency', 3)->default('USD');
            $table->string('status', 50)->default('available_to_discuss');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['package_id', 'starts_on']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_departures');
    }
};
