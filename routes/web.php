<?php

use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\ApproachPageController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FaqPageController;
use App\Http\Controllers\GuestReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageInquiryController;
use App\Http\Controllers\PackageListingController;
use App\Http\Controllers\SiteInquiryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TeamPageController;
use App\Http\Controllers\TravelInfoController;
use App\Http\Controllers\WhyChooseUsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/subcategories/{subcategory:slug}', [SubcategoryController::class, 'show'])->name('subcategories.show');
Route::get('/about-us', AboutPageController::class)->name('about');
Route::get('/our-approach', ApproachPageController::class)->name('approach');
Route::get('/our-team', TeamPageController::class)->name('team');
Route::get('/why-choose-us', WhyChooseUsController::class)->name('why-choose-us');
Route::get('/guest-reviews', GuestReviewController::class)->name('guest-reviews');
Route::get('/travel-info', [TravelInfoController::class, 'index'])->name('travel-info.index');
Route::get('/travel-info/{slug}', [TravelInfoController::class, 'show'])->name('travel-info.show');
Route::get('/faq', FaqPageController::class)->name('faq');
Route::view('/contact-us', 'site.contact')->name('contact');
Route::post('/inquiries', [SiteInquiryController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('site-inquiries.store');
Route::post('/newsletter/subscriptions', [NewsletterSubscriptionController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('newsletter.subscriptions.store');
Route::get('/newsletter/unsubscribe/{newsletterSubscriber}/{token}', [NewsletterSubscriptionController::class, 'confirmUnsubscribe'])
    ->middleware(['signed', 'throttle:10,1'])
    ->name('newsletter.unsubscribe.show');
Route::post('/newsletter/unsubscribe/{newsletterSubscriber}/{token}', [NewsletterSubscriptionController::class, 'unsubscribe'])
    ->middleware(['signed', 'throttle:10,1'])
    ->name('newsletter.unsubscribe.destroy');
Route::post('/packages/{package}/inquiries', [PackageInquiryController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('packages.inquiries.store');
Route::get('/packages/{package}/booking', [PackageBookingController::class, 'create'])
    ->name('packages.bookings.create');
Route::post('/packages/{package}/booking', [PackageBookingController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('packages.bookings.store');
Route::get('/packages/{package}/booking/thank-you/{reference}', [PackageBookingController::class, 'thankYou'])
    ->middleware('signed')
    ->name('packages.bookings.thank-you');
Route::get('/packages', PackageListingController::class)->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

require __DIR__.'/settings.php';
require __DIR__.'/admin/web.php';
