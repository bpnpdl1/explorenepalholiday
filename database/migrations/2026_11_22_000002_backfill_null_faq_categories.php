<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('faqs')
            ->whereNull('category')
            ->update(['category' => 'planning']);
    }

    public function down(): void
    {
        // Existing FAQ rows should retain their assigned topic when this migration is rolled back.
    }
};
