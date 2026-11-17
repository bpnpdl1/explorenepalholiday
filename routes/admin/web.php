<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RichContentImageController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('rich-content/images', RichContentImageController::class)
        ->middleware('throttle:30,1')
        ->name('rich-content.images.store');
});
