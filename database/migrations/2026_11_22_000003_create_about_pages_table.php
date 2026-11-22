<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->longText('content');
            $table->timestamps();
        });

        $now = now();

        DB::table('about_pages')->insert([
            'id' => 1,
            'content' => <<<'HTML'
<h1>About Us</h1>
<h2>Discover Nepal at your own pace</h2>
<p>Explore Nepal Holidays helps travellers find a journey that fits their interests, time and preferred pace. From mountain trails and historic cities to wildlife lowlands, Nepal has many ways to explore.</p>
<p>We start with what matters to you, then discuss routes, seasons and practical details so you can choose a trip with a clear picture of what it involves.</p>
<p><img src="/site/assets/kathmandu-stupa.jpg" alt="Boudhanath Stupa and prayer flags in Kathmandu" width="1200" height="800"></p>
<p>Nepal's living heritage is part of the journey.</p>
<h2>What you can explore</h2>
<p>Our travel ideas span trekking, cultural tours, wildlife experiences and tailor-made journeys. You can focus on one interest or combine several places and experiences in the time you have.</p>
<ul>
<li><strong>Trekking:</strong> Choose from gentler valley walks to more demanding mountain routes.</li>
<li><strong>Culture:</strong> Spend time with Nepal's heritage, local traditions and everyday life.</li>
<li><strong>Wildlife:</strong> Explore the forests and lowlands of the Terai.</li>
<li><strong>Tailor-made travel:</strong> Discuss a route shaped around your own priorities.</li>
</ul>
<h2>Planning with the details in mind</h2>
<p>A useful itinerary considers more than destinations. Walking hours, altitude, road travel, accommodation, permits and seasonal conditions all affect how a trip feels. We aim to make those details clear while you compare your options.</p>
<p>Tell us when you hope to travel, how long you have and what you would most like to experience. We can then talk through a route that suits your plans.</p>
<h2>Travel with care</h2>
<p>Respect for local communities, shared spaces and Nepal's landscapes belongs in every journey. Good preparation also helps you travel more comfortably, especially where weather, altitude or remote roads can change the day.</p>
<p>Ready to begin? <a href="/packages">Explore our journeys</a> or <a href="/contact-us">share your travel ideas</a>.</p>
HTML,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
