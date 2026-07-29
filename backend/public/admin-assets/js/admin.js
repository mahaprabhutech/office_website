(() => {
    'use strict';

    const qs = (selector, root = document) => root.querySelector(selector);
    const qsa = (selector, root = document) => [...root.querySelectorAll(selector)];

    const shell = qs('[data-admin-shell]');
    const sidebar = qs('[data-sidebar]');

    qsa('[data-sidebar-open]').forEach((button) => {
        button.addEventListener('click', () => {
            shell?.classList.add('sidebar-open');
            document.body.classList.add('no-scroll');
        });
    });

    qsa('[data-sidebar-close]').forEach((button) => {
        button.addEventListener('click', () => {
            shell?.classList.remove('sidebar-open');
            document.body.classList.remove('no-scroll');
        });
    });

    const profileMenu = qs('[data-profile-menu]');
    const profileTrigger = qs('[data-profile-trigger]', profileMenu || document);

    profileTrigger?.addEventListener('click', (event) => {
        event.stopPropagation();
        const open = profileMenu.classList.toggle('is-open');
        profileTrigger.setAttribute('aria-expanded', String(open));
    });

    document.addEventListener('click', (event) => {
        if (profileMenu && !profileMenu.contains(event.target)) {
            profileMenu.classList.remove('is-open');
            profileTrigger?.setAttribute('aria-expanded', 'false');
        }
    });

    qsa('[data-alert-close]').forEach((button) => {
        button.addEventListener('click', () => button.closest('.alert')?.remove());
    });

    window.setTimeout(() => {
        qsa('[data-auto-dismiss]').forEach((alert) => {
            alert.classList.add('is-hiding');
            window.setTimeout(() => alert.remove(), 280);
        });
    }, 5500);

    qsa('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.dataset.confirm || 'Are you sure?';
            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    qsa('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const field = qs('[data-password-input]', button.closest('.password-field') || document);
            if (!field) return;
            const reveal = field.type === 'password';
            field.type = reveal ? 'text' : 'password';
            button.textContent = reveal ? 'Hide' : 'Show';
        });
    });

    qsa('[data-image-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;

            const wrapper = input.closest('.upload-field');
            let preview = qs('[data-image-preview]', wrapper);
            const placeholder = qs('[data-upload-placeholder]', wrapper);

            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'upload-preview';
                preview.dataset.imagePreview = '';
                wrapper.prepend(preview);
            }

            preview.src = URL.createObjectURL(file);
            preview.onload = () => URL.revokeObjectURL(preview.src);
            placeholder?.remove();
        });
    });

    qsa('textarea').forEach((textarea) => {
        const resize = () => {
            if (!textarea.classList.contains('rich-editor')) return;
            textarea.style.height = 'auto';
            textarea.style.height = `${Math.max(textarea.scrollHeight, 250)}px`;
        };
        textarea.addEventListener('input', resize);
        resize();
    });

    const activeLink = qs('.admin-sidebar .nav-link.is-active');
    if (activeLink && sidebar) {
        activeLink.scrollIntoView({ block: 'nearest' });
    }
})();
