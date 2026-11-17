# Admin rich text editor

The admin panel uses Quill 2 with the Velzon-compatible Snow theme. The reusable Blade field supports headings, text styles and colors, lists, alignment, quotes, code blocks, links, tables, video embeds, and inline image uploads.

Use it in a regular Blade form:

```blade
<x-admin::rich-editor
    name="description"
    label="Package description"
    :value="old('description', $package->description ?? '')"
    placeholder="Describe this experience..."
/>
```

For a Livewire form, pass the model binding to the component. It is applied to the hidden textarea while Quill's editing surface is protected with `wire:ignore`:

```blade
<x-admin::rich-editor
    name="description"
    label="Package description"
    wire:model="description"
    placeholder="Describe this experience..."
/>
```

Quill synchronizes HTML into the named textarea for normal form submissions and Livewire. Image uploads go to the admin-only `admin.rich-content.images.store` endpoint and are stored on Laravel's public disk under `rich-content/` (JPG, PNG, or WebP, up to 5 MB).

Use `App\Services\RichContentSanitizer` before persisting editor output:

```php
$content = app(\App\Services\RichContentSanitizer::class)->sanitize($validated['description']);
```

For safe rendering, use the `x-rich-content` component instead of outputting editor HTML directly:

```blade
<x-rich-content :html="$package->description" class="package-description" />
```

The `rich_content` HTML Purifier profile allows Quill's semantic headings, text styles, lists, links, tables, images, and HTTPS YouTube/Vimeo embeds. It strips scripts, event handlers, unsafe URL schemes, and arbitrary iframe sources. Image uploads remain separate files on the public disk.
