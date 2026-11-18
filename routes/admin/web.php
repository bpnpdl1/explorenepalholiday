<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GuestReviewController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RichContentImageController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhyTravelReasonController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('destinations', DestinationController::class)->except('show');
    Route::resource('faqs', FaqController::class)->except('show');
    Route::resource('guest-reviews', GuestReviewController::class)
        ->except('show')
        ->parameters(['guest-reviews' => 'guestReview']);
    Route::resource('subcategories', SubcategoryController::class)->except('show');
    Route::resource('team-members', TeamMemberController::class)
        ->except('show')
        ->parameters(['team-members' => 'teamMember']);
    Route::resource('why-travel-reasons', WhyTravelReasonController::class)
        ->except('show')
        ->parameters(['why-travel-reasons' => 'whyTravelReason']);
    Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('rich-content/images', RichContentImageController::class)
        ->middleware('throttle:30,1')
        ->name('rich-content.images.store');
});
