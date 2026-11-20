<?php

namespace App\Actions\Notifications;

use App\Mail\PackageBookingSubmittedMail;
use App\Mail\PackageInquirySubmittedMail;
use App\Mail\SiteInquirySubmittedMail;
use App\Models\PackageBooking;
use App\Models\PackageInquiry;
use App\Models\SiteInquiry;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendSubmissionNotificationsAction
{
    public function handle(SiteInquiry|PackageInquiry|PackageBooking $submission): void
    {
        $adminRecipients = $this->adminRecipients();

        if ($submission instanceof SiteInquiry) {
            $this->sendSiteInquiryEmails($submission, $adminRecipients);

            return;
        }

        if ($submission instanceof PackageInquiry) {
            $submission->loadMissing('package.departures', 'package.seasons');
            $this->sendPackageInquiryEmails($submission, $adminRecipients);

            return;
        }

        $submission->loadMissing(['package', 'departure']);
        $this->sendBookingEmails($submission, $adminRecipients);
    }

    /** @param list<string> $adminRecipients */
    private function sendSiteInquiryEmails(SiteInquiry $inquiry, array $adminRecipients): void
    {
        $this->sendToAdmins(new SiteInquirySubmittedMail($inquiry, adminAlert: true), $adminRecipients, 'site inquiry', $inquiry->id);
        $this->send(new SiteInquirySubmittedMail($inquiry), $inquiry->email, 'site inquiry', $inquiry->id, 'customer');
    }

    /** @param list<string> $adminRecipients */
    private function sendPackageInquiryEmails(PackageInquiry $inquiry, array $adminRecipients): void
    {
        $this->sendToAdmins(new PackageInquirySubmittedMail($inquiry, adminAlert: true), $adminRecipients, 'package inquiry', $inquiry->id);
        $this->send(new PackageInquirySubmittedMail($inquiry), $inquiry->email, 'package inquiry', $inquiry->id, 'customer');
    }

    /** @param list<string> $adminRecipients */
    private function sendBookingEmails(PackageBooking $booking, array $adminRecipients): void
    {
        $this->sendToAdmins(new PackageBookingSubmittedMail($booking, adminAlert: true), $adminRecipients, 'package booking', $booking->id);
        $this->send(new PackageBookingSubmittedMail($booking), $booking->email, 'package booking', $booking->id, 'customer');
    }

    /** @return list<string> */
    private function adminRecipients(): array
    {
        $configuredAddress = config('admin.email');
        $adminAddresses = User::query()->where('is_admin', true)->pluck('email')->all();
        $candidateAddresses = array_merge(is_string($configuredAddress) ? [$configuredAddress] : [], $adminAddresses);
        $recipients = [];

        foreach ($candidateAddresses as $email) {
            if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                continue;
            }

            if (! in_array($email, $recipients, true)) {
                $recipients[] = $email;
            }
        }

        return $recipients;
    }

    /** @param list<string> $recipients */
    private function sendToAdmins(Mailable $mail, array $recipients, string $submissionType, int $submissionId): void
    {
        if ($recipients === []) {
            $this->send($mail, null, $submissionType, $submissionId, 'admin');

            return;
        }

        foreach ($recipients as $recipient) {
            $this->send(clone $mail, $recipient, $submissionType, $submissionId, 'admin');
        }
    }

    private function send(
        Mailable $mail,
        ?string $recipient,
        string $submissionType,
        int $submissionId,
        string $audience,
    ): void {
        if (! is_string($recipient) || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            Log::warning('Submission notification was not sent because the recipient address is missing or invalid.', [
                'submission_type' => $submissionType,
                'submission_id' => $submissionId,
                'audience' => $audience,
            ]);

            return;
        }

        try {
            Mail::to($recipient)->send($mail);
        } catch (Throwable $exception) {
            Log::warning('Submission notification could not be sent.', [
                'submission_type' => $submissionType,
                'submission_id' => $submissionId,
                'audience' => $audience,
                'exception' => $exception,
            ]);
        }
    }
}
