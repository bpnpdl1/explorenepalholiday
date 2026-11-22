<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_info_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });

        $now = now();

        DB::table('travel_info_pages')->insert([
            [
                'title' => 'Best Time to Visit Nepal',
                'slug' => 'best-time-to-visit',
                'content' => <<<'HTML'
<h2>Choose a season around your plans</h2>
<p>Spring and autumn are popular seasons for many treks. Cities and lowland areas can be rewarding at other times too. The best time depends on your route and what you want to experience.</p>
<h2>Think about the whole journey</h2>
<p>Consider the places you want to visit, how much time you have, and the kind of activities that matter most to you. Conditions can vary by route and elevation, so plan with your destinations in mind.</p>
<p>Share your preferred dates and interests with our team. We can discuss which routes and experiences may suit your plans.</p>
HTML,
                'sort_order' => 1,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Trekking Experience',
                'slug' => 'trekking-experience',
                'content' => <<<'HTML'
<h2>Find a route that suits you</h2>
<p>Whether you need trekking experience depends on the route. Some walks can suit first-time trekkers who prepare well; longer or higher routes call for stronger fitness and experience. Tell us about your background when choosing a trek.</p>
<h2>Prepare for the walking days</h2>
<p>Many treks involve several hours of walking on uneven trails, stairs and gradual climbs. Regular walking or hill training can help you prepare. Choose a pace and itinerary that feel right for your group.</p>
<h2>Plan for altitude and insurance</h2>
<p>Choose an itinerary with a sensible ascent and acclimatization time. Arrange travel insurance that explicitly covers trekking at your planned altitude, medical treatment and emergency evacuation. Check the details of your policy before you travel.</p>
<h2>Ask for a route-specific packing list</h2>
<p>Layers, comfortable broken-in walking shoes, rain protection, sun protection and personal medication are common starting points. Exact gear depends on season, route and altitude, so confirm a route-specific list before departure.</p>
HTML,
                'sort_order' => 2,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Combining Experiences',
                'slug' => 'combining-experiences',
                'content' => <<<'HTML'
<h2>More than one way to explore</h2>
<p>A custom journey can combine a trek, time in Kathmandu and a visit to the lowlands. You can focus on one interest or combine several places and experiences in the time you have.</p>
<h2>Build a comfortable itinerary</h2>
<p>Travel time and season help determine a comfortable itinerary. Share your available days, preferred pace and the places or activities you most want to experience, and we can discuss suitable options.</p>
<h2>Make the trip your own</h2>
<p>Some travelers want active days on the trail; others prefer more time for culture, wildlife or city exploration. Your itinerary can balance different interests around your priorities.</p>
<p><a href="/contact-us">Talk with us about your travel ideas</a> and we can explore what may fit your trip.</p>
HTML,
                'sort_order' => 3,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_info_pages');
    }
};
