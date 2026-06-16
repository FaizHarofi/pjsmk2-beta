@props([
    'name',
    'value' => '',
    'id' => null,
    'height' => 500,
])

@php
    $id = $id ?: 'rt-' . md5($name);
    $uploadUrl = route('admin.upload.image');
    $listUrl = route('admin.upload.list');
@endphp

<textarea id="{{ $id }}" data-tinymce data-height="{{ (int)$height }}" data-upload="{{ $uploadUrl }}" data-list="{{ $listUrl }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>

@once
@push('head')
<style>
.lp-overlay { position: fixed !important; inset: 0 !important; z-index: 2147483647 !important; background: rgba(0,0,0,0.65); display: flex; align-items: center; justify-content: center; padding: 1rem; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Plus Jakarta Sans", sans-serif; }
.lp-dialog { background: #fff; border-radius: 10px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); width: 100%; max-width: 1080px; max-height: 88vh; display: flex; flex-direction: column; overflow: hidden; }
.lp-head { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.lp-head h2 { font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; }
.lp-head p { font-size: 12px; color: #64748b; margin: 2px 0 0; }
.lp-close { background: none; border: none; color: #94a3b8; cursor: pointer; padding: 6px; line-height: 0; border-radius: 4px; }
.lp-close:hover { color: #475569; background: #f1f5f9; }
.lp-toolbar { padding: 10px 20px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 10px; align-items: center; background: #f8fafc; }
.lp-tabs { display: flex; gap: 4px; flex: 1; overflow-x: auto; }
.lp-tabs button { padding: 6px 10px; font-size: 12px; font-weight: 600; color: #64748b; background: transparent; border: none; border-bottom: 2px solid transparent; cursor: pointer; white-space: nowrap; text-transform: capitalize; font-family: inherit; }
.lp-tabs button:hover { color: #334155; }
.lp-tabs button.active { color: #0C4A6E; border-bottom-color: #0C4A6E; background: #fff; }
.lp-search { position: relative; width: 220px; }
.lp-search svg { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
.lp-search input { width: 100%; padding: 6px 10px 6px 30px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; box-sizing: border-box; font-family: inherit; }
.lp-search input:focus { border-color: #0C4A6E; box-shadow: 0 0 0 3px rgba(12,74,110,0.15); }
.lp-body { flex: 1; overflow-y: auto; padding: 16px; min-height: 320px; background: #f8fafc; }
.lp-empty { text-align: center; padding: 48px 16px; color: #94a3b8; }
.lp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
.lp-card-wrap { position: relative; }
.lp-card { background: #fff; border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden; text-align: left; cursor: pointer; padding: 0; font-family: inherit; transition: all .15s; width: 100%; }
.lp-card:hover { border-color: #0C4A6E; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.lp-card.selected { border-color: #0C4A6E; background: #f0f9ff; }
.lp-card-check { position: absolute; top: 8px; left: 8px; width: 20px; height: 20px; z-index: 5; cursor: pointer; accent-color: #0C4A6E; opacity: 0; transition: opacity .15s; }
.lp-card-wrap:hover .lp-card-check, .lp-card-wrap.lp-checked .lp-card-check { opacity: 1; }
.lp-card-wrap.lp-checked .lp-card { border-color: #dc2626; background: #fef2f2; }
.lp-del-btn { position: absolute; top: 6px; right: 6px; width: 28px; height: 28px; background: rgba(220, 38, 38, 0.95); color: #fff; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .15s; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
.lp-card-wrap:hover .lp-del-btn { opacity: 1; }
.lp-del-btn:hover { background: #b91c1c; transform: scale(1.1); }
.lp-thumb { aspect-ratio: 1/1; background: #f1f5f9; overflow: hidden; }
.lp-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.lp-meta { padding: 8px; }
.lp-name { font-size: 11px; font-family: monospace; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lp-info { display: flex; justify-content: space-between; font-size: 10px; color: #94a3b8; margin-top: 2px; }
.lp-foot { padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; font-size: 12px; color: #64748b; gap: 12px; }
.lp-foot-left { display: flex; align-items: center; gap: 14px; }
.lp-select-all { display: flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; }
.lp-select-all input { width: 16px; height: 16px; cursor: pointer; accent-color: #0C4A6E; }
.lp-counter { color: #dc2626; font-weight: 600; font-size: 12px; }
.lp-actions { display: flex; gap: 8px; }
.lp-btn-primary { padding: 6px 14px; background: #0C4A6E; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; }
.lp-btn-primary:hover { background: #075985; }
.lp-btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.lp-btn-danger { padding: 6px 14px; background: #dc2626; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; }
.lp-btn-danger:hover { background: #b91c1c; }
.lp-btn-danger:disabled { opacity: 0.4; cursor: not-allowed; background: #94a3b8; }
.lp-btn-ghost { padding: 6px 14px; background: transparent; color: #475569; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: inherit; }
.lp-btn-ghost:hover { background: #f1f5f9; }
@keyframes lp-spin { to { transform: rotate(360deg); } }
.lp-spinner { width: 32px; height: 32px; animation: lp-spin 1s linear infinite; }
</style>
@endpush
@endonce

@once
@push('head')
<script>
(function() {
    var busy = false;

    function esc(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

            function buildModal(initialFolder) {
        var overlay = document.createElement('div');
        overlay.className = 'lp-overlay';
        overlay.id = 'lp-overlay';
        overlay.innerHTML = ''
            + '<div class="lp-dialog">'
            +   '<div class="lp-head">'
            +     '<div><h2>Media Library</h2><p>Pilih gambar dari file yang sudah diupload</p></div>'
            +     '<button type="button" class="lp-close" id="lp-close-btn" title="Tutup (Esc)">'
            +       '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
            +     '</button>'
            +   '</div>'
            +   '<div class="lp-toolbar">'
            +     '<div class="lp-tabs" id="lp-tabs"></div>'
            +     '<div class="lp-search">'
            +       '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
            +       '<input type="text" id="lp-search-input" placeholder="Cari nama file...">'
            +     '</div>'
            +   '</div>'
            +   '<div class="lp-body" id="lp-body"></div>'
            +   '<div class="lp-foot">'
            +     '<div class="lp-foot-left">'
            +       '<label class="lp-select-all"><input type="checkbox" id="lp-select-all"> <span>Pilih semua</span></label>'
            +       '<span class="lp-counter" id="lp-counter"></span>'
            +     '</div>'
            +     '<div class="lp-actions">'
            +       '<button type="button" class="lp-btn-danger" id="lp-bulk-delete-btn" disabled>Hapus Terpilih (<span id="lp-bulk-count">0</span>)</button>'
            +       '<button type="button" class="lp-btn-ghost" id="lp-cancel-btn">Batal</button>'
            +       '<button type="button" class="lp-btn-primary" id="lp-insert-btn" disabled>Pakai Gambar</button>'
            +     '</div>'
            +   '</div>'
            + '</div>';
        document.body.appendChild(overlay);
        return overlay;
    }

    function debounce(fn, ms) { var t; return function() { var a = arguments, c = this; clearTimeout(t); t = setTimeout(function() { fn.apply(c, a); }, ms); }; }

    function renderTabs(state) {
        var tabs = document.getElementById('lp-tabs');
        if (!tabs) return;
        var html = '<button type="button" data-folder=""' + (state.folder === '' ? ' class="active"' : '') + '>Semua</button>';
        (state.folders || []).forEach(function(f) {
            html += '<button type="button" data-folder="' + esc(f) + '"' + (state.folder === f ? ' class="active"' : '') + '>' + esc(f) + '</button>';
        });
        tabs.innerHTML = html;
        tabs.querySelectorAll('button').forEach(function(btn) {
            btn.addEventListener('click', function() { state.folder = btn.dataset.folder; state.page = 1; loadFiles(state); });
        });
    }

    function renderBody(state) {
        var body = document.getElementById('lp-body');
        var total = document.getElementById('lp-total');
        var page = document.getElementById('lp-page');
        if (total) total.textContent = state.total;
        if (page) page.textContent = state.page;
        var prev = document.getElementById('lp-prev');
        var next = document.getElementById('lp-next');
        if (prev) prev.disabled = state.page === 1;
        if (next) next.disabled = !state.hasMore;

        if (state.loading) {
            body.innerHTML = '<div class="lp-empty"><svg class="lp-spinner" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#0C4A6E" stroke-width="4" fill="none" opacity="0.25"/><path fill="#0C4A6E" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" opacity="0.75"/></svg><p style="margin-top:12px">Memuat...</p></div>';
            return;
        }
        if (!state.items.length) {
            body.innerHTML = '<div class="lp-empty"><svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 8px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg><p>Belum ada file di folder ini.</p></div>';
            return;
        }
        var html = '<div class="lp-grid">';
        state.items.forEach(function(item) {
            var sel = state.selected && state.selected.path === item.path ? ' selected' : '';
            var checked = state.selectedPaths && state.selectedPaths[item.path] ? ' checked' : '';
            html += '<div class="lp-card-wrap">'
                + '<input type="checkbox" class="lp-card-check" data-path="' + esc(item.path) + '"' + checked + '>'
                + '<button type="button" class="lp-card' + sel + '" data-path="' + esc(item.path) + '" data-url="' + esc(item.url) + '" data-name="' + esc(item.name) + '">'
                + '<div class="lp-thumb"><img src="' + esc(item.url) + '" alt="' + esc(item.name) + '" loading="lazy"></div>'
                + '<div class="lp-meta"><div class="lp-name">' + esc(item.name) + '</div>'
                + '<div class="lp-info"><span>' + item.size_kb + ' KB</span><span>' + esc(item.modified) + '</span></div></div>'
                + '</button>'
                + '<button type="button" class="lp-del-btn" data-path="' + esc(item.path) + '" title="Hapus file ini">'
                + '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>'
                + '</button>'
                + '</div>';
        });
        html += '</div>';
        body.innerHTML = html;
        body.querySelectorAll('.lp-card').forEach(function(card) {
            card.addEventListener('click', function(e) {
                if (e.target.closest('.lp-card-check')) return;
                state.selected = { path: card.dataset.path, url: card.dataset.url, name: card.dataset.name };
                var info = document.getElementById('lp-selected-info');
                var insertBtn = document.getElementById('lp-insert-btn');
                if (info) info.textContent = 'Dipilih: ' + card.dataset.name;
                if (insertBtn) insertBtn.disabled = false;
                body.querySelectorAll('.lp-card').forEach(function(c) { c.classList.remove('selected'); });
                card.classList.add('selected');
            });
            card.addEventListener('dblclick', function() {
                state.selected = { path: card.dataset.path, url: card.dataset.url, name: card.dataset.name };
                document.getElementById('lp-insert-btn').click();
            });
        });
        body.querySelectorAll('.lp-del-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                deleteFiles([btn.dataset.path], state);
            });
        });
        body.querySelectorAll('.lp-card-check').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var p = cb.dataset.path;
                if (cb.checked) { state.selectedPaths[p] = true; cb.closest('.lp-card-wrap').classList.add('lp-checked'); }
                else { delete state.selectedPaths[p]; cb.closest('.lp-card-wrap').classList.remove('lp-checked'); }
                updateBulkUI(state);
            });
        });
    }

    function updateBulkUI(state) {
        var paths = Object.keys(state.selectedPaths);
        var count = paths.length;
        var countEl = document.getElementById('lp-bulk-count');
        var delBtn = document.getElementById('lp-bulk-delete-btn');
        var selectAll = document.getElementById('lp-select-all');
        var counter = document.getElementById('lp-counter');
        if (countEl) countEl.textContent = count;
        if (delBtn) delBtn.disabled = count === 0;
        if (counter) counter.textContent = count > 0 ? count + ' file dipilih' : '';
        if (selectAll) {
            var total = state.items.length;
            selectAll.checked = total > 0 && count === total;
            selectAll.indeterminate = count > 0 && count < total;
        }
    }

    function deleteFiles(paths, state) {
        if (!paths.length) return;
        if (!confirm('Hapus ' + paths.length + ' file?\n\n' + paths.slice(0, 5).join('\n') + (paths.length > 5 ? '\n...' : '') + '\n\nFile yang masih dipakai akan dilewati.')) return;
        var csrf = document.querySelector('meta[name=csrf-token]').content;
        fetch(window.location.origin + '/admin/upload/delete', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ paths: paths })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                var msg = (data.data && data.data.deleted ? data.data.deleted.length : 0) + ' dihapus';
                if (data.data && data.data.skipped && Object.keys(data.data.skipped).length) {
                    msg += ', ' + Object.keys(data.data.skipped).length + ' dilewati (masih dipakai)';
                }
                alert(msg);
                state.selectedPaths = {};
                loadFiles(state);
            } else {
                alert('Gagal: ' + (data.message || 'unknown'));
            }
        })
        .catch(function(err) { alert('Error: ' + err.message); });
    }

    function loadFiles(state) {
        state.loading = true;
        renderBody(state);
        var ta = document.querySelector('textarea[data-tinymce]');
        var listUrl = ta ? ta.dataset.list : '/admin/upload/list';
        var url = new URL(listUrl, window.location.origin);
        if (state.folder) url.searchParams.set('folder', state.folder);
        if (state.search) url.searchParams.set('search', state.search);
        if (state.page > 1) url.searchParams.set('page', state.page);
        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                state.loading = false;
                if (data.status === 'success') {
                    state.items = data.data.items;
                    state.folders = data.data.folders;
                    state.total = data.data.total;
                    state.hasMore = data.data.has_more;
                }
                renderTabs(state);
                renderBody(state);
            })
            .catch(function() { state.loading = false; renderBody(state); });
    }

    function closeModal(state) {
        var el = document.getElementById('lp-overlay');
        if (el) el.remove();
        document.body.style.overflow = '';
        if (state && state.resolveCb) { state.resolveCb(null); state.resolveCb = null; }
    }

    window.openMediaLibrary = function() {
        if (busy) { console.warn('[Library] busy'); return null; }
        busy = true;
        setTimeout(function() { busy = false; }, 600);
        return new Promise(function(resolve) {
            var state = {
                folder: '', search: '', page: 1, items: [], folders: [],
                total: 0, hasMore: false, loading: false, selected: null,
                selectedPaths: {},
                resolveCb: resolve
            };
            buildModal();
            document.body.style.overflow = 'hidden';
            document.getElementById('lp-close-btn').addEventListener('click', function() { closeModal(state); });
            document.getElementById('lp-cancel-btn').addEventListener('click', function() { closeModal(state); });
            document.getElementById('lp-insert-btn').addEventListener('click', function() {
                if (state.selected) {
                    var item = state.selected;
                    var cb = state.resolveCb;
                    var el = document.getElementById('lp-overlay');
                    if (el) el.remove();
                    document.body.style.overflow = '';
                    state.resolveCb = null;
                    if (cb) cb(item);
                }
            });
            document.getElementById('lp-bulk-delete-btn').addEventListener('click', function() {
                var paths = Object.keys(state.selectedPaths);
                if (paths.length) deleteFiles(paths, state);
            });
            document.getElementById('lp-select-all').addEventListener('change', function(e) {
                if (e.target.checked) {
                    state.items.forEach(function(it) { state.selectedPaths[it.path] = true; });
                } else {
                    state.selectedPaths = {};
                }
                renderBody(state);
                updateBulkUI(state);
            });
            document.getElementById('lp-search-input').addEventListener('input', debounce(function(e) {
                state.search = e.target.value;
                state.page = 1;
                loadFiles(state);
            }, 400));
            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape' && document.getElementById('lp-overlay')) {
                    document.removeEventListener('keydown', escHandler);
                    closeModal(state);
                }
            });
            loadFiles(state);
        });
    };
})();
</script>
@endpush
@endonce

@once
@push('head')
<script>
window.initTinyMCEEditors = function() {
    if (typeof window.tinymce === 'undefined') {
        setTimeout(window.initTinyMCEEditors, 100);
        return;
    }
    document.querySelectorAll('textarea[data-tinymce]:not(.tinymce-initialized)').forEach(function(ta) {
        if (ta.classList.contains('tinymce-initialized')) return;
        ta.classList.add('tinymce-initialized');
        var uploadUrl = ta.dataset.upload;
        window.tinymce.init({
            target: ta,
            license_key: 'gpl',
            height: parseInt(ta.dataset.height || 500),
            menubar: 'file edit view insert format tools table help',
            plugins: 'advlist autolink lists link image charmap anchor searchreplace visualblocks code fullscreen media table help wordcount preview',
            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image imageMedia table | code fullscreen preview | help',
            toolbar_mode: 'sliding',
            branding: false,
            promotion: false,
            statusbar: true,
            elementpath: false,
            content_style: 'body{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;line-height:1.7;padding:1rem;color:#1e293b}h1,h2,h3{color:#0C4A6E}img{max-width:100%;height:auto;border-radius:.5rem}table{border-collapse:collapse}table td,table th{border:1px solid #cbd5e1;padding:.5rem .75rem}pre{background:#0f172a;color:#e2e8f0;padding:1rem;border-radius:.5rem;overflow-x:auto}blockquote{border-left:4px solid #0C4A6E;padding-left:1rem;color:#475569;font-style:italic}a{color:#0284C7}',
            images_upload_handler: function(blobInfo) {
                return new Promise(function(resolve, reject) {
                    var fd = new FormData();
                    fd.append('image_data', 'data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
                    fd.append('folder', 'artikels/konten');
                    var csrf = document.querySelector('meta[name=csrf-token]').content;
                    fd.append('_token', csrf);
                    fetch(uploadUrl, { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                        .then(function(r) { return r.json(); })
                        .then(function(data) { data.status === 'success' ? resolve(data.data.url) : reject(data.message || 'Upload gagal'); })
                        .catch(function(err) { reject('Error: ' + err.message); });
                });
            },
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (typeof window.openMediaLibrary !== 'function') {
                    callback('', { title: 'Library not loaded' });
                    return;
                }
                window.openMediaLibrary().then(function(item) {
                    if (item && item.url) {
                        var src = item.path ? '/uploads/' + item.path : item.url;
                        callback(src, { title: item.name, alt: item.name, text: item.name });
                    } else {
                        callback('');
                    }
                });
            },
            setup: function(editor) {
                editor.ui.registry.addIcon('imageMedia', '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>');
                editor.ui.registry.addButton('imageMedia', {
                    icon: 'imageMedia',
                    tooltip: 'Pilih dari Media Library',
                    onAction: function() {
                        if (typeof window.openMediaLibrary === 'function') {
                            window.openMediaLibrary().then(function(item) {
                                if (item && item.url) {
                        var src = item.path ? '/uploads/' + item.path : item.url;
                                    editor.insertContent('<img src="' + src + '" alt="' + item.name + '" style="max-width:100%;height:auto;border-radius:.5rem" />');
                                }
                            });
                        }
                    }
                });
                editor.on('change keyup paste', function() {
                    var el = document.getElementById(ta.id);
                    if (el) el.value = editor.getContent();
                });
            },
            init_instance_callback: function(editor) {
                if (ta.value) editor.setContent(ta.value);
            }
        });
    });
};
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.initTinyMCEEditors);
} else {
    window.initTinyMCEEditors();
}
</script>
@endpush
@endonce
