<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\View\Composers\SiteNavigationComposer;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(resource_path('views/admin/layouts'), 'admin-layouts');
        Blade::anonymousComponentPath(resource_path('views/admin/partials'), 'admin');

        view()->composer(['layouts.site', 'site.*'], function (View $view): void {
            $siteSettingData = Cache::rememberForever(SiteSetting::CACHE_KEY, static function (): ?array {
                $siteSetting = SiteSetting::query()
                    ->with('media')
                    ->first();

                if (! $siteSetting) {
                    return null;
                }

                return [
                    'name' => $siteSetting->name,
                    'tagline' => $siteSetting->tagline,
                    'description' => $siteSetting->description,
                    'email' => $siteSetting->email,
                    'phone' => $siteSetting->phone,
                    'whatsapp_number' => $siteSetting->whatsapp_number,
                    'address' => $siteSetting->address,
                    'social_links' => $siteSetting->social_links,
                    'meta_title' => $siteSetting->meta_title,
                    'meta_description' => $siteSetting->meta_description,
                    'canonical_url' => $siteSetting->canonical_url,
                    'og_title' => $siteSetting->og_title,
                    'og_description' => $siteSetting->og_description,
                    'logo_url' => $siteSetting->getFirstMediaUrl('logo'),
                    'footer_logo_url' => $siteSetting->getFirstMediaUrl('footer-logo'),
                    'favicon_url' => $siteSetting->getFirstMediaUrl('favicon'),
                ];
            });

            $view->with('siteSetting', $siteSettingData === null ? null : (object) $siteSettingData);
        });

        view()->composer('site.partials.header', SiteNavigationComposer::class);

        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
