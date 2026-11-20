<?php

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($admin);
});

test('admin can update site metadata and upload all site identity images', function () {
    Storage::fake(config('media-library.disk_name'));
    $setting = SiteSetting::query()->create(['name' => 'Explore Nepal Holidays']);
    Cache::forever(SiteSetting::CACHE_KEY, ['stale' => true]);

    $this->put(route('admin.site-settings.update'), [
        'name' => 'Explore Nepal Holidays Updated',
        'tagline' => 'Journeys made personal',
        'email' => 'hello@example.test',
        'meta_title' => 'Nepal Adventures',
        'meta_description' => 'Explore Nepal with local experts.',
        'social_links' => ['facebook' => 'https://facebook.com/example', 'instagram' => ''],
        'logo' => UploadedFile::fake()->image('logo.png', 600, 200),
        'footer_logo' => UploadedFile::fake()->image('footer-logo.png', 600, 200),
        'favicon' => UploadedFile::fake()->image('favicon.png', 32, 32),
    ])->assertRedirect(route('admin.site-settings.edit'))
        ->assertSessionHas('success');

    $setting->refresh();
    expect($setting->name)->toBe('Explore Nepal Holidays Updated')
        ->and($setting->meta_title)->toBe('Nepal Adventures')
        ->and($setting->social_links)->toBe(['facebook' => 'https://facebook.com/example']);

    foreach (['logo', 'footer-logo', 'favicon'] as $collection) {
        expect($setting->getMedia($collection))->toHaveCount(1);
        $media = $setting->getFirstMedia($collection);
        Storage::disk($media->disk)->assertExists($media->getPathRelativeToRoot());
    }

    expect(Cache::get(SiteSetting::CACHE_KEY))->toBeNull();
});

test('invalid site setting uploads do not replace persisted settings', function () {
    $setting = SiteSetting::query()->create(['name' => 'Original Name']);

    $this->from(route('admin.site-settings.edit'))->put(route('admin.site-settings.update'), [
        'name' => 'Changed Name',
        'favicon' => UploadedFile::fake()->image('small.png', 8, 8),
    ])->assertSessionHasErrors('favicon');

    expect($setting->refresh()->name)->toBe('Original Name');
});
