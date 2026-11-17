<?php

namespace App\Services;

use Mews\Purifier\Facades\Purifier;

class RichContentSanitizer
{
    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        return (string) Purifier::clean($html, 'rich_content');
    }
}
