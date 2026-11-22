<?php

use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\ApproachPageController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GuestReviewController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageDepartureController;
use App\Http\Controllers\Admin\PackageReviewController;
use App\Http\Controllers\Admin\RichContentImageController;
use App\Http\Controllers\Admin\SiteInquiryController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TravelInfoPageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhyTravelReasonController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
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
    Route::resource('travel-info-pages', TravelInfoPageController::class)
        ->except('show')
        ->parameters(['travel-info-pages' => 'travelInfoPage']);
    Route::resource('why-travel-reasons', WhyTravelReasonController::class)
        ->except('show')
        ->parameters(['why-travel-reasons' => 'whyTravelReason']);
    Route::get('about-page', [AboutPageController::class, 'edit'])->name('about-page.edit');
    Route::put('about-page', [AboutPageController::class, 'update'])->name('about-page.update');
    Route::get('approach-page', [ApproachPageController::class, 'edit'])->name('approach-page.edit');
    Route::put('approach-page', [ApproachPageController::class, 'update'])->name('approach-page.update');
    Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{packageInquiry}', [InquiryController::class, 'show'])
        ->name('inquiries.show');
    Route::patch('inquiries/{packageInquiry}', [InquiryController::class, 'updateStatus'])
        ->name('inquiries.update-status');
    Route::get('site-inquiries', [SiteInquiryController::class, 'index'])->name('site-inquiries.index');
    Route::get('site-inquiries/{siteInquiry}', [SiteInquiryController::class, 'show'])->name('site-inquiries.show');
    Route::patch('site-inquiries/{siteInquiry}/status', [SiteInquiryController::class, 'updateStatus'])
        ->name('site-inquiries.update-status');
    Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])
        ->name('newsletter-subscribers.index');
    Route::get('newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])
        ->name('newsletter-subscribers.export');
    Route::patch('newsletter-subscribers/{newsletterSubscriber}/status', [NewsletterSubscriberController::class, 'updateStatus'])
        ->name('newsletter-subscribers.update-status');
    Route::get('packages/categories', [PackageController::class, 'categoriesForDestination'])
        ->name('packages.categories');
    Route::get('packages/subcategories', [PackageController::class, 'subcategoriesForCategory'])
        ->name('packages.subcategories');
    Route::resource('packages', PackageController::class);
    Route::get('package-reviews/package/{package}', [PackageReviewController::class, 'forPackage'])
        ->name('package-reviews.package');
    Route::resource('package-reviews', PackageReviewController::class)
        ->except('show')
        ->parameters(['package-reviews' => 'packageReview']);
    Route::get('package-departures/package/{package}', [PackageDepartureController::class, 'forPackage'])
        ->name('package-departures.package');
    Route::resource('package-departures', PackageDepartureController::class)
        ->except('show')
        ->parameters(['package-departures' => 'packageDeparture']);
    Route::resource('users', UserController::class)->except('show');
    Route::post('rich-content/images', RichContentImageController::class)
        ->middleware('throttle:30,1')
        ->name('rich-content.images.store');
});
