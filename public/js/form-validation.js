(() => {
    'use strict';

    const messageIds = new WeakMap();
    let messageSequence = 0;

    function isLivewireForm(form) {
        return Array.from(form.attributes).some((attribute) => attribute.name.startsWith('wire:submit'));
    }

    function shouldValidate(form) {
        if (form.hasAttribute('data-no-client-validation') || form.hasAttribute('data-package-wizard-form')) {
            return false;
        }

        return form.method.toLowerCase() !== 'get' || isLivewireForm(form);
    }

    function initializeForm(form) {
        if (!(form instanceof HTMLFormElement) || !shouldValidate(form) || form.dataset.validationReady === 'true') {
            return;
        }

        form.dataset.validationReady = 'true';
        form.noValidate = true;
        form.classList.add('needs-validation');
    }

    function validationMessage(control) {
        const validity = control.validity;

        if (validity.valueMissing) {
            return control.type === 'checkbox' || control.type === 'radio'
                ? 'Please select this option to continue.'
                : control instanceof HTMLSelectElement
                    ? 'Please choose an option.'
                    : 'Please complete this field.';
        }

        if (validity.typeMismatch) {
            if (control.type === 'email') return 'Enter a valid email address.';
            if (control.type === 'url') return 'Enter a valid URL.';
        }

        if (validity.patternMismatch) {
            return control.title || 'Use the requested format.';
        }

        if (validity.tooShort) return `Enter at least ${control.minLength} characters.`;
        if (validity.tooLong) return `Use no more than ${control.maxLength} characters.`;
        if (validity.rangeUnderflow) return `Choose a value on or after ${control.min}.`;
        if (validity.rangeOverflow) return `Choose a value on or before ${control.max}.`;
        if (validity.stepMismatch) return 'Choose a valid value.';
        if (validity.badInput) return control.validationMessage || 'Enter a valid value.';
        if (validity.customError) return control.validationMessage || 'Check this field.';

        return control.validationMessage || 'Check this field.';
    }

    function richEditorFor(control) {
        return control.closest('[data-rich-editor]');
    }

    function visualControl(control) {
        const editor = richEditorFor(control);

        if (editor) {
            return editor.querySelector('[data-rich-editor-surface]');
        }

        const select2 = control.nextElementSibling;

        return select2?.classList.contains('select2-container') ? select2 : control;
    }

    function feedbackAnchor(control) {
        const editor = richEditorFor(control);

        if (editor) return editor;

        const inputGroup = control.closest('.input-group, .newsletter-field');
        if (inputGroup) return inputGroup;

        const select2 = control.nextElementSibling;

        if (select2?.classList.contains('select2-container')) return select2;

        const choiceGroup = control.closest('.form-check, .newsletter-consent, .booking-consent, .package-checkbox');

        return choiceGroup || control;
    }

    function serverFeedbackFor(control) {
        const editor = richEditorFor(control);

        if (editor) return editor.querySelector('.invalid-feedback');

        const inputGroup = control.closest('.input-group, .newsletter-field');
        if (inputGroup?.nextElementSibling?.classList.contains('invalid-feedback')) {
            return inputGroup.nextElementSibling;
        }

        let feedback = control.nextElementSibling;

        if (feedback?.classList.contains('select2-container')) {
            feedback = feedback.nextElementSibling;
        }

        return feedback?.classList.contains('invalid-feedback') ? feedback : null;
    }

    function feedbackFor(control) {
        let feedback = messageIds.get(control);

        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'client-validation-message';
            feedback.setAttribute('role', 'alert');
            feedback.id = `client-validation-${++messageSequence}`;

            const anchor = feedbackAnchor(control);
            anchor.insertAdjacentElement('afterend', feedback);

            const descriptions = (control.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean);
            if (!descriptions.includes(feedback.id)) {
                control.setAttribute('aria-describedby', [...descriptions, feedback.id].join(' '));
            }
        }

        messageIds.set(control, feedback);

        return feedback;
    }

    function showInvalid(control) {
        serverFeedbackFor(control)?.classList.add('d-none');

        const feedback = feedbackFor(control);
        const visual = visualControl(control);

        feedback.textContent = validationMessage(control);
        feedback.classList.add('is-visible');
        control.classList.add('client-invalid');
        control.setAttribute('aria-invalid', 'true');
        visual?.classList.add('client-invalid');
    }

    function clearInvalid(control) {
        if (!(control instanceof HTMLElement)) return;

        const feedback = messageIds.get(control);
        const visual = visualControl(control);

        feedback?.classList.remove('is-visible');
        control.classList.remove('client-invalid');
        visual?.classList.remove('client-invalid');

        if (!control.classList.contains('is-invalid')) {
            control.removeAttribute('aria-invalid');
        }
    }

    function clearServerError(control) {
        if (!control.classList.contains('is-invalid')) return;

        control.classList.remove('is-invalid');

        serverFeedbackFor(control)?.classList.add('d-none');

        if (!control.classList.contains('client-invalid')) {
            control.removeAttribute('aria-invalid');
        }
    }

    function syncPasswordConfirmations(form) {
        const passwords = form.querySelectorAll('input[type="password"][name="password"], input[type="password"][data-password-field="password"]');

        passwords.forEach((password) => {
            const confirmation = form.querySelector('input[type="password"][name="password_confirmation"], input[type="password"][data-password-field="confirmation"]');

            if (!confirmation) return;

            const requiredByForm = password.dataset.passwordRequired === 'true'
                || confirmation.dataset.passwordRequired === 'true'
                || password.hasAttribute('required')
                || confirmation.hasAttribute('required');
            const editing = password.value !== '' || confirmation.value !== '';

            password.required = requiredByForm || editing;
            confirmation.required = requiredByForm || editing;
            confirmation.setCustomValidity(
                editing && password.value !== confirmation.value
                    ? 'Enter the same password in both fields.'
                    : '',
            );
        });
    }

    function syncRichEditors(form) {
        form.querySelectorAll('[data-rich-editor-input]').forEach((input) => {
            const editor = richEditorFor(input)?.querySelector('.ql-editor');

            if (!editor) return;

            const hasText = editor.textContent.trim() !== '';
            const hasMedia = Boolean(editor.querySelector('img, video, iframe, table'));

            if (!hasText && !hasMedia) input.value = '';
        });
    }

    function focusInvalid(control) {
        const visual = visualControl(control);

        if (visual?.classList.contains('select2-container')) {
            visual.querySelector('.select2-selection')?.focus();
            return;
        }

        if (richEditorFor(control)) {
            visual?.setAttribute('tabindex', '0');
            visual?.focus();
            return;
        }

        control.focus();
    }

    window.FormValidation = Object.freeze({
        validateControl(control) {
            if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement)) {
                return true;
            }

            clearServerError(control);

            if (control.validity.valid) {
                clearInvalid(control);
                return true;
            }

            showInvalid(control);
            return false;
        },
        validateControls(controls) {
            return Array.from(controls).filter((control) => !window.FormValidation.validateControl(control));
        },
        clearControl(control) {
            clearInvalid(control);
        },
        focusControl(control) {
            focusInvalid(control);
        },
    });

    function validateForm(form, event) {
        if (!shouldValidate(form)) return;

        initializeForm(form);
        syncRichEditors(form);
        syncPasswordConfirmations(form);

        const controls = Array.from(form.elements).filter((control) => control.willValidate);
        const invalidControls = controls.filter((control) => !control.validity.valid);

        form.classList.add('was-validated');

        if (invalidControls.length === 0) return;

        event.preventDefault();
        event.stopPropagation();

        invalidControls.forEach(showInvalid);
        focusInvalid(invalidControls[0]);
    }

    function visitForms(root) {
        if (!(root instanceof Element || root instanceof Document)) return;

        if (root instanceof HTMLFormElement) initializeForm(root);
        root.querySelectorAll?.('form').forEach(initializeForm);
    }

    document.querySelectorAll('form').forEach(initializeForm);

    document.addEventListener('submit', (event) => {
        if (event.target instanceof HTMLFormElement) validateForm(event.target, event);
    }, true);

    document.addEventListener('input', (event) => {
        const control = event.target;

        if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement)) return;

        const form = control.form;
        if (!form || !shouldValidate(form)) return;

        syncPasswordConfirmations(form);

        clearServerError(control);

        if (form.classList.contains('was-validated')) {
            Array.from(form.elements)
                .filter((field) => field.willValidate)
                .forEach((field) => field.validity.valid ? clearInvalid(field) : showInvalid(field));
        }
    });

    document.addEventListener('change', (event) => {
        const control = event.target;

        if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement)) return;

        const form = control.form;
        if (!form || !shouldValidate(form)) return;

        syncPasswordConfirmations(form);

        clearServerError(control);

        if (form.classList.contains('was-validated')) {
            Array.from(form.elements)
                .filter((field) => field.willValidate)
                .forEach((field) => field.validity.valid ? clearInvalid(field) : showInvalid(field));
        }
    });

    document.addEventListener('reset', (event) => {
        if (!(event.target instanceof HTMLFormElement)) return;

        window.setTimeout(() => {
            event.target.classList.remove('was-validated');
            Array.from(event.target.elements).forEach(clearInvalid);
            syncPasswordConfirmations(event.target);
        });
    }, true);

    new MutationObserver((records) => {
        records.forEach((record) => record.addedNodes.forEach(visitForms));
    }).observe(document.documentElement, { childList: true, subtree: true });
})();
