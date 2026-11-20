<?php

use App\Mail\SiteInquirySubmittedMail;
use App\Models\SiteInquiry;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('visitor can submit a site inquiry with a normalized phone number', function () {
    config(['admin.email' => 'operations@example.test']);
    Mail::fake();

    $this->post(route('site-inquiries.store'), [
        'name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'country_code' => '+977',
        'phone' => ' 9812345678 ',
        'interest' => 'Trekking',
        'message' => 'Please send details.',
        'source' => 'contact',
    ])->assertRedirect(route('contact').'#contact-section-title')
        ->assertSessionHas('site_inquiry_submitted', true);

    $this->assertDatabaseHas('site_inquiries', [
        'name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '+977 9812345678',
        'interest' => 'Trekking',
        'status' => 'new',
    ]);

    Mail::assertSent(
        SiteInquirySubmittedMail::class,
        fn (SiteInquirySubmittedMail $mail): bool => $mail->render() !== ''
            && $mail->adminAlert
            && $mail->hasTo('operations@example.test'),
    );
    Mail::assertSent(
        SiteInquirySubmittedMail::class,
        fn (SiteInquirySubmittedMail $mail): bool => $mail->render() !== ''
            && ! $mail->adminAlert
            && $mail->hasTo('alex@example.test'),
    );
});

test('invalid site inquiries are rejected without creating a record', function () {
    Mail::fake();

    $this->from(route('contact'))->post(route('site-inquiries.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'source' => 'invalid',
    ])->assertSessionHasErrors(['name', 'email', 'source']);

    expect(SiteInquiry::query()->count())->toBe(0);
    Mail::assertNothingOutgoing();
});

test('site inquiry alerts all admin accounts when no admin email is configured', function () {
    config(['admin.email' => null]);
    Mail::fake();

    foreach (['admin-one@example.test', 'admin-two@example.test'] as $email) {
        User::factory()->create(['email' => $email])->forceFill(['is_admin' => true])->save();
    }

    $this->post(route('site-inquiries.store'), [
        'name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'country_code' => '+977',
        'phone' => '9812345678',
        'source' => 'contact',
    ])->assertSessionHas('site_inquiry_submitted', true);

    foreach (['admin-one@example.test', 'admin-two@example.test'] as $email) {
        Mail::assertSent(
            SiteInquirySubmittedMail::class,
            fn (SiteInquirySubmittedMail $mail): bool => $mail->adminAlert && $mail->hasTo($email),
        );
    }
});
