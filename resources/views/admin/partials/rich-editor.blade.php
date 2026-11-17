@props([
    'name',
    'label' => null,
    'value' => '',
    'placeholder' => 'Write your content here...',
    'help' => 'Use headings, lists, links, tables, photos, and video embeds to format your content.',
])

@php($editorId = 'rich-editor-'.\Illuminate\Support\Str::uuid())

<div class="admin-rich-editor" data-rich-editor data-upload-url="{{ route('admin.rich-content.images.store') }}">
    @if ($label)
        <label class="form-label" for="{{ $editorId }}-surface">{{ $label }}</label>
    @endif

    <div class="admin-rich-editor-toolbar" data-rich-editor-toolbar aria-label="Rich text formatting toolbar">
        <span class="ql-formats">
            <select class="ql-header" aria-label="Text style">
                <option selected></option>
                <option value="1">Heading 1</option>
                <option value="2">Heading 2</option>
                <option value="3">Heading 3</option>
            </select>
            <select class="ql-size" aria-label="Text size">
                <option value="small"></option>
                <option selected></option>
                <option value="large"></option>
                <option value="huge"></option>
            </select>
        </span>
        <span class="ql-formats">
            <button type="button" class="ql-bold" aria-label="Bold"></button>
            <button type="button" class="ql-italic" aria-label="Italic"></button>
            <button type="button" class="ql-underline" aria-label="Underline"></button>
            <button type="button" class="ql-strike" aria-label="Strikethrough"></button>
            <button type="button" class="ql-script" value="sub" aria-label="Subscript"></button>
            <button type="button" class="ql-script" value="super" aria-label="Superscript"></button>
        </span>
        <span class="ql-formats">
            <select class="ql-color" aria-label="Text color"></select>
            <select class="ql-background" aria-label="Text background color"></select>
        </span>
        <span class="ql-formats">
            <button type="button" class="ql-list" value="ordered" aria-label="Numbered list"></button>
            <button type="button" class="ql-list" value="bullet" aria-label="Bulleted list"></button>
            <button type="button" class="ql-indent" value="-1" aria-label="Decrease indent"></button>
            <button type="button" class="ql-indent" value="+1" aria-label="Increase indent"></button>
        </span>
        <span class="ql-formats">
            <select class="ql-align" aria-label="Text alignment"></select>
            <button type="button" class="ql-blockquote" aria-label="Block quote"></button>
            <button type="button" class="ql-code-block" aria-label="Code block"></button>
        </span>
        <span class="ql-formats">
            <button type="button" class="ql-link" aria-label="Insert link"></button>
            <button type="button" class="ql-image" aria-label="Upload image"></button>
            <button type="button" class="ql-video" aria-label="Insert video"></button>
            <button type="button" class="ql-insertTable" aria-label="Insert table"><i class="ri-table-line"></i></button>
            <button type="button" class="ql-clean" aria-label="Clear formatting"></button>
        </span>
    </div>

    <div
        class="admin-rich-editor-surface"
        id="{{ $editorId }}-surface"
        data-rich-editor-surface
        data-placeholder="{{ $placeholder }}"
        @if ($label) aria-label="{{ $label }}" @endif
        wire:ignore
    ></div>

    <textarea
        id="{{ $editorId }}-input"
        class="d-none"
        name="{{ $name }}"
        data-rich-editor-input
        {{ $attributes }}
    >{{ $value }}</textarea>

    @if ($help)
        <div class="form-text">{{ $help }}</div>
    @endif
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@pushOnce('styles', 'admin-rich-editor-styles')
    @vite('resources/css/admin-rich-editor.css')
@endPushOnce

@pushOnce('scripts', 'admin-rich-editor-script')
    @vite('resources/js/admin/rich-editor.js')
@endPushOnce
