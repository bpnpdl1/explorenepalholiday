@props(['html' => ''])

<div {{ $attributes }}>{!! app(\App\Services\RichContentSanitizer::class)->sanitize($html) !!}</div>
