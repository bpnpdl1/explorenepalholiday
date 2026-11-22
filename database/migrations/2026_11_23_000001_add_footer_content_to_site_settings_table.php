<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('footer_resources_eyebrow')->nullable();
            $table->string('footer_resources_title')->nullable();
            $table->text('footer_resources_description')->nullable();
            $table->json('footer_resources')->nullable();
            $table->string('footer_payment_title')->nullable();
            $table->text('footer_payment_description')->nullable();
        });

        DB::table('site_settings')->whereNull('footer_resources_eyebrow')->update([
            'footer_resources_eyebrow' => 'PLAN WITH GOOD INFORMATION',
            'footer_resources_title' => 'Nepal travel resources',
            'footer_resources_description' => 'External organizations for travel, conservation and trekking guidance.',
            'footer_resources' => json_encode([
                ['name' => 'Government of Nepal tourism ministry', 'url' => 'https://tourism.gov.np/', 'logo' => '/site/assets/nepal-goverment.svg', 'alt' => 'Government of Nepal tourism ministry'],
                ['name' => 'Nepal Tourism Board', 'url' => 'https://ntb.gov.np/', 'logo' => '/site/assets/ntb.svg', 'alt' => 'Nepal Tourism Board'],
                ['name' => 'Nepal Mountaineering Association', 'url' => 'https://www.nepalmountaineering.org/', 'logo' => '/site/assets/nma.svg', 'alt' => 'Nepal Mountaineering Association'],
                ['name' => "Trekking Agencies' Association of Nepal", 'url' => 'https://www.taan.org.np/', 'logo' => '/site/assets/taan.svg', 'alt' => "Trekking Agencies' Association of Nepal"],
                ['name' => 'Kathmandu Environmental Education Project', 'url' => 'https://keepnepal.org/', 'logo' => '/site/assets/keep.webp', 'alt' => 'Kathmandu Environmental Education Project'],
            ], JSON_THROW_ON_ERROR),
            'footer_payment_title' => 'PAYMENT OPTIONS',
            'footer_payment_description' => 'Card networks shown as examples. Accepted methods are confirmed before you pay.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'footer_resources_eyebrow',
                'footer_resources_title',
                'footer_resources_description',
                'footer_resources',
                'footer_payment_title',
                'footer_payment_description',
            ]);
        });
    }
};
