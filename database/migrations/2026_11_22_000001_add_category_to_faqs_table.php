<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('category', 32)->default('planning')->after('answer');
            $table->index(['category', 'is_published', 'sort_order']);
        });

        $faqs = [
            ['planning', 'When is a good time to visit Nepal?', 'Spring and autumn are popular for many treks. Cities and lowland areas can be rewarding at other times too. The best season depends on your route and what you want to experience.', 1],
            ['planning', 'How do I choose the right trip?', 'Start with your available days, walking experience, comfort with altitude and the landscapes you most want to see. These details help narrow the options.', 2],
            ['planning', 'Can I combine trekking, culture and wildlife?', 'Yes. A custom journey can combine a trek, time in Kathmandu and a visit to the lowlands. Travel time and season help determine a comfortable itinerary.', 3],
            ['planning', 'Can you tailor a trip to my dates and interests?', 'Share your preferred dates, group size, interests and pace. The team can discuss suitable route options and confirm the final itinerary with you.', 4],
            ['trekking', 'Do I need trekking experience?', 'It depends on the route. Some walks suit first-time trekkers who prepare well; longer or higher routes call for stronger fitness and experience. Discuss your background when choosing a trek.', 5],
            ['trekking', 'How fit do I need to be?', 'Many treks involve several hours of walking on uneven trails, stairs and gradual climbs. Build regular walking or hill training into your preparation, and choose a pace that suits you.', 6],
            ['trekking', 'How should I prepare for altitude?', 'Choose an itinerary with a sensible ascent and acclimatization time. Follow your guide’s advice, tell them about symptoms promptly, and seek medical help if you feel unwell.', 7],
            ['trekking', 'What travel insurance should I arrange?', 'Arrange insurance that explicitly covers trekking at your planned altitude, medical treatment and emergency evacuation. Check the policy details before you travel.', 8],
            ['trekking', 'What should I pack?', 'Pack in layers and bring comfortable broken-in walking shoes, rain protection, sun protection and personal medication. Exact gear depends on season, route and altitude; confirm a route-specific list before departure.', 9],
            ['booking', 'Are the trips listed on the site ready to book?', 'Listed trips are a starting point for an enquiry. Routes, dates, inclusions, prices and availability are confirmed with you before a trip is offered.', 10],
            ['booking', 'What happens after I send an enquiry?', 'The team reviews your dates, interests and group details, then follows up to discuss suitable options and any questions before confirming a plan.', 11],
            ['booking', 'When will the final price and inclusions be confirmed?', 'Your written trip plan should set out the agreed itinerary, inclusions and price before you make a payment. Ask the team to clarify any item that is not listed.', 12],
            ['booking', 'Which payment methods can I use?', 'Available payment methods and any applicable charges are confirmed with your trip details before you pay. Please follow the payment instructions provided for your booking.', 13],
        ];

        $now = now();

        foreach ($faqs as [$category, $question, $answer, $sortOrder]) {
            $existingFaqs = DB::table('faqs')->where('question', $question);

            if ($existingFaqs->exists()) {
                $existingFaqs->update(['category' => $category]);

                continue;
            }

            DB::table('faqs')->insert([
                'question' => $question,
                'answer' => $answer,
                'category' => $category,
                'sort_order' => $sortOrder,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['category', 'is_published', 'sort_order']);
            $table->dropColumn('category');
        });
    }
};
