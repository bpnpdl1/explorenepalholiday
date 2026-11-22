<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $content = DB::table('about_pages')->where('id', 1)->value('content');

        if (! is_string($content)) {
            return;
        }

        $contentWithoutReviews = preg_replace(
            '~<h2\b[^>]*>\s*Client Reviews\s*</h2>.*$~is',
            '',
            $content,
        );

        if (is_string($contentWithoutReviews) && $contentWithoutReviews !== $content) {
            DB::table('about_pages')
                ->where('id', 1)
                ->update([
                    'content' => rtrim($contentWithoutReviews),
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Reviews now come from guest_reviews and should not be restored as copied About Us content.
    }
};
