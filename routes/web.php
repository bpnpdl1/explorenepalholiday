<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');
Route::view('/packages/langtang-valley-trek', 'site.package')->name('packages.show');

require __DIR__.'/settings.php';
require __DIR__.'/admin/web.php';
