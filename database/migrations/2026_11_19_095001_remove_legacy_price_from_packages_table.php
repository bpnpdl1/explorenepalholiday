<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('packages') || ! Schema::hasColumn('packages', 'price')) {
            return;
        }

        if (Schema::hasColumn('packages', 'price_from')) {
            DB::table('packages')
                ->whereNull('price_from')
                ->whereNotNull('price')
                ->update(['price_from' => DB::raw('price')]);
        }

        Schema::table('packages', fn (Blueprint $table) => $table->dropColumn('price'));
    }

    public function down(): void
    {
        if (! Schema::hasTable('packages') || Schema::hasColumn('packages', 'price')) {
            return;
        }

        Schema::table('packages', fn (Blueprint $table) => $table->decimal('price', 10, 2)->nullable());

        if (Schema::hasColumn('packages', 'price_from')) {
            DB::table('packages')
                ->whereNull('price')
                ->whereNotNull('price_from')
                ->update(['price' => DB::raw('price_from')]);
        }
    }
};
