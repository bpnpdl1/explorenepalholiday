<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approach_pages', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->longText('content');
            $table->timestamps();
        });

        $now = now();

        DB::table('approach_pages')->insert([
            'id' => 1,
            'content' => <<<'HTML'
<h1>Our Approach</h1>
<h2>Take the road. Feel the place.</h2>
<p>A great journey makes room for wonder, conversation, and the unexpected. These are the things we want you to have space for, whether you are walking for two weeks or exploring a city for two days.</p>
<p><img src="/site/assets/photo-1544735716-392fe2489ffa.avif" alt="Trekkers passing a prayer-flagged stupa beneath snow-covered Himalayan peaks" width="1200" height="800"></p>
<h2>Go beyond the postcard</h2>
<p>Find meaningful moments in Nepal's streets, villages, landscapes and everyday life.</p>
<h2>Travel at your pace</h2>
<p>Choose an active challenge, a slower cultural journey, or a little of both.</p>
<h2>Make it yours</h2>
<p>Tell us what matters to you and we can discuss a journey shaped around it.</p>
<p><a href="/contact-us">Let's plan something memorable</a></p>
HTML,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('approach_pages');
    }
};
