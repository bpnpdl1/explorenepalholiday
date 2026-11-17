import Quill from 'quill';

const instances = new WeakMap();

function notifyError(message) {
    if (window.Swal) {
        window.Swal.fire({
            icon: 'error',
            title: 'Image upload failed',
            text: message,
        });

        return;
    }

    window.AdminToast?.show(message, 'error');
}

function insertImage(editorRoot, quill) {
    const selection = quill.getSelection(true);
    const filePicker = document.createElement('input');
    filePicker.type = 'file';
    filePicker.accept = 'image/jpeg,image/png,image/webp';
    filePicker.hidden = true;
    editorRoot.append(filePicker);

    filePicker.addEventListener('change', async () => {
        const [file] = filePicker.files || [];
        filePicker.remove();

        if (!file) {
            return;
        }

        const formData = new FormData();
        formData.append('image', file);

        try {
            const response = await fetch(editorRoot.dataset.uploadUrl, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: formData,
            });
            const result = await response.json();

            if (!response.ok || !result.url) {
                const firstError = Object.values(result.errors || {}).flat()[0];
                throw new Error(firstError || result.message || 'Please choose a JPG, PNG, or WebP image up to 5 MB.');
            }

            const index = selection?.index ?? Math.max(quill.getLength() - 1, 0);
            quill.insertEmbed(index, 'image', result.url, 'user');
            quill.setSelection(index + 1, 0, 'silent');
        } catch (error) {
            notifyError(error.message || 'Please try again.');
        }
    }, { once: true });

    filePicker.click();
}

async function insertTable(quill) {
    let dimensions = { rows: 3, columns: 2 };

    if (window.Swal) {
        const result = await window.Swal.fire({
            title: 'Insert table',
            html: '<div class="text-start"><label class="form-label" for="rich-table-rows">Rows</label><input id="rich-table-rows" class="form-control mb-3" type="number" min="1" max="12" value="3"><label class="form-label" for="rich-table-columns">Columns</label><input id="rich-table-columns" class="form-control" type="number" min="1" max="8" value="2"></div>',
            showCancelButton: true,
            confirmButtonText: 'Insert table',
            preConfirm: () => {
                const rows = Number(document.getElementById('rich-table-rows')?.value);
                const columns = Number(document.getElementById('rich-table-columns')?.value);

                if (!Number.isInteger(rows) || rows < 1 || rows > 12 || !Number.isInteger(columns) || columns < 1 || columns > 8) {
                    window.Swal.showValidationMessage('Choose 1–12 rows and 1–8 columns.');
                    return false;
                }

                return { rows, columns };
            },
        });

        if (!result.isConfirmed) {
            return;
        }

        dimensions = result.value;
    }

    quill.getModule('table')?.insertTable(dimensions.rows, dimensions.columns);
}

function syncInput(editor) {
    const { input, quill } = editor;
    const content = quill.getText().trim().length === 0 ? '' : quill.getSemanticHTML();

    if (input.value !== content) {
        input.value = content;
        input.dispatchEvent(new Event('input', { bubbles: true }));
    }
}

function syncEditorFromInput(editor) {
    const { input, quill } = editor;
    const currentContent = quill.getText().trim().length === 0 ? '' : quill.getSemanticHTML();

    if (input.value !== currentContent) {
        quill.clipboard.dangerouslyPasteHTML(input.value || '', 'silent');
    }
}

function initializeEditor(root) {
    if (instances.has(root)) {
        return;
    }

    const surface = root.querySelector('[data-rich-editor-surface]');
    const toolbar = root.querySelector('[data-rich-editor-toolbar]');
    const input = root.querySelector('[data-rich-editor-input]');

    if (!surface || !toolbar || !input) {
        return;
    }

    const quill = new Quill(surface, {
        theme: 'snow',
        placeholder: surface.dataset.placeholder || 'Write your content here...',
        modules: {
            table: true,
            toolbar: {
                container: toolbar,
                handlers: {
                    image() {
                        insertImage(root, quill);
                    },
                    insertTable() {
                        insertTable(quill);
                    },
                },
            },
        },
    });
    const editor = { input, quill };
    instances.set(root, editor);

    if (input.value) {
        quill.clipboard.dangerouslyPasteHTML(input.value, 'silent');
    }

    quill.on('text-change', () => syncInput(editor));
    input.addEventListener('input', () => syncEditorFromInput(editor));
    input.addEventListener('change', () => syncEditorFromInput(editor));
    input.closest('form')?.addEventListener('submit', () => syncInput(editor));
}

function initializeWithin(element = document) {
    if (element instanceof Element && element.matches('[data-rich-editor]')) {
        initializeEditor(element);
    }

    element.querySelectorAll?.('[data-rich-editor]').forEach(initializeEditor);
}

initializeWithin();

const observer = new MutationObserver((records) => {
    records.forEach((record) => record.addedNodes.forEach((node) => {
        if (node instanceof Element) {
            initializeWithin(node);
        }
    }));
});

observer.observe(document.body, { childList: true, subtree: true });

function registerLivewireMorphHook() {
    if (!window.Livewire?.hook) {
        document.addEventListener('livewire:init', registerLivewireMorphHook, { once: true });
        return;
    }

    window.Livewire.hook('morphed', ({ el }) => {
        initializeWithin(el);

        if (el instanceof Element && el.matches('[data-rich-editor]')) {
            const editor = instances.get(el);
            if (editor) syncEditorFromInput(editor);
        }

        el.querySelectorAll?.('[data-rich-editor]').forEach((root) => {
            const editor = instances.get(root);
            if (editor) syncEditorFromInput(editor);
        });
    });
}

registerLivewireMorphHook();
