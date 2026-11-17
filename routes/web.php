<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');
Route::view('/about-us', 'site.about')->name('about');
Route::view('/our-team', 'site.team')->name('team');
Route::view('/faq', 'site.faq')->name('faq');
Route::view('/contact-us', 'site.contact')->name('contact');
Route::view('/packages/langtang-valley-trek', 'site.package')->name('packages.show');

require __DIR__.'/settings.php';
require __DIR__.'/admin/web.php';
