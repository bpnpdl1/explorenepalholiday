<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GuestReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\PackageInquiryController;
use App\Http\Controllers\TeamPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
Route::view('/about-us', 'site.about')->name('about');
Route::get('/our-team', TeamPageController::class)->name('team');
Route::get('/guest-reviews', GuestReviewController::class)->name('guest-reviews');
Route::view('/faq', 'site.faq')->name('faq');
Route::view('/contact-us', 'site.contact')->name('contact');
Route::post('/packages/{package}/inquiries', [PackageInquiryController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('packages.inquiries.store');
Route::get('/packages/{package}/booking', [PackageBookingController::class, 'create'])
    ->name('packages.bookings.create');
Route::post('/packages/{package}/booking', [PackageBookingController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('packages.bookings.store');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

require __DIR__.'/settings.php';
require __DIR__.'/admin/web.php';
