<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GuestReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
Route::view('/about-us', 'site.about')->name('about');
Route::get('/our-team', TeamPageController::class)->name('team');
Route::get('/guest-reviews', GuestReviewController::class)->name('guest-reviews');
Route::view('/faq', 'site.faq')->name('faq');
Route::view('/contact-us', 'site.contact')->name('contact');
Route::view('/packages/langtang-valley-trek', 'site.package')->name('packages.show');

require __DIR__.'/settings.php';
require __DIR__.'/admin/web.php';
