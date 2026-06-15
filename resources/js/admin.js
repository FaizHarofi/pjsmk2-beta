window.AdminAjax = (() => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    async function request(url, options = {}) {
        const opts = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                ...(options.headers || {}),
            },
            ...options,
        };
        if (opts.body instanceof FormData) {
            delete opts.headers['Content-Type'];
        } else if (opts.body && typeof opts.body === 'object') {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(opts.body);
        }
        const res = await fetch(url, opts);
        const ct = res.headers.get('content-type') || '';
        const data = ct.includes('application/json') ? await res.json() : { status: res.ok ? 'success' : 'error', message: res.statusText };
        return { ok: res.ok, status: res.status, data };
    }

    function toast(message, type = 'success') {
        const colors = {
            success: 'bg-emerald-500',
            error:   'bg-red-500',
            info:    'bg-sky-500',
            warning: 'bg-amber-500',
        };
        const icons = {
            success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
            error:   '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
            info:    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        };
        const wrap = document.getElementById('toast-container') || (() => {
            const c = document.createElement('div');
            c.id = 'toast-container';
            c.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none';
            document.body.appendChild(c);
            return c;
        })();
        const el = document.createElement('div');
        el.className = `pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl text-white shadow-2xl ${colors[type] || colors.info} text-sm font-medium transform transition-all duration-300 translate-x-96`;
        el.innerHTML = icons[type] + '<span>' + message + '</span>';
        wrap.appendChild(el);
        requestAnimationFrame(() => el.classList.remove('translate-x-96'));
        setTimeout(() => {
            el.classList.add('translate-x-96', 'opacity-0');
            setTimeout(() => el.remove(), 300);
        }, 3500);
    }

    async function toggle(url, label = 'Status') {
        const { ok, data } = await request(url, { method: 'POST' });
        if (ok && data.status === 'success') {
            toast(data.message || label + ' diperbarui', 'success');
            return data;
        }
        toast(data.message || 'Gagal', 'error');
        return null;
    }

    async function bulkDelete(url, ids) {
        if (!ids.length) {
            toast('Pilih item dulu', 'warning');
            return;
        }
        if (!confirm('Hapus ' + ids.length + ' item?')) return;
        const { ok, data } = await request(url, { method: 'POST', body: { ids } });
        if (ok && data.status === 'success') {
            toast(data.message, 'success');
            setTimeout(() => location.reload(), 600);
        } else {
            toast(data.message || 'Gagal', 'error');
        }
    }

    async function pollUnread() {
        try {
            const { ok, data } = await request('/admin/kontak/unread-count', { method: 'GET' });
            if (ok && data.data) {
                document.querySelectorAll('[data-unread-badge]').forEach(b => {
                    const c = data.data.unread_count;
                    b.textContent = c;
                    b.classList.toggle('hidden', c === 0);
                });
            }
        } catch (e) {}
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('[data-unread-badge]')) {
            pollUnread();
            setInterval(pollUnread, 30000);
        }

        document.addEventListener('click', async (e) => {
            const t = e.target.closest('[data-ajax-toggle]');
            if (t) {
                e.preventDefault();
                await toggle(t.dataset.url, t.dataset.label || 'Status');
                const dot = t.querySelector('[data-ajax-dot]');
                if (dot) dot.classList.toggle('bg-emerald-500');
                if (dot) dot.classList.toggle('bg-slate-300');
            }
        });

        const bulkForm = document.querySelector('[data-bulk-form]');
        if (bulkForm) {
            const checkAll = bulkForm.querySelector('[data-check-all]');
            const checks = bulkForm.querySelectorAll('[data-check]');
            const counter = bulkForm.querySelector('[data-bulk-count]');
            const update = () => {
                const sel = [...checks].filter(c => c.checked);
                if (counter) counter.textContent = sel.length;
                if (checkAll) checkAll.checked = sel.length === checks.length;
            };
            if (checkAll) checkAll.addEventListener('change', () => {
                checks.forEach(c => c.checked = checkAll.checked);
                update();
            });
            checks.forEach(c => c.addEventListener('change', update));
            const bulkBtn = bulkForm.querySelector('[data-bulk-delete]');
            if (bulkBtn) {
                bulkBtn.addEventListener('click', () => {
                    const ids = [...checks].filter(c => c.checked).map(c => c.value);
                    bulkDelete(bulkBtn.dataset.url, ids);
                });
            }
        }
    });

    return { request, toast, toggle, bulkDelete, pollUnread };
})();
