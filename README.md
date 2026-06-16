# SMKN 2 Pekanbaru — Website Remake

Website resmi **SMKN 2 Pekanbaru** berbasis Laravel dengan panel admin, manajemen konten dinamis, rich text editor, media library, dan proteksi aset. Referensi desain: [https://smkn2-pekanbaru.sch.id](https://smkn2-pekanbaru.sch.id).

---

## Daftar Isi

- [Tech Stack](#tech-stack)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Default Accounts](#default-accounts)
- [Routes](#routes)
- [Architecture](#architecture)
- [Deployment](#deployment)
- [Useful Commands](#useful-commands)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 13.15 (PHP 8.3+) |
| **Database** | MySQL 8 / MariaDB 10.6+ |
| **Frontend** | Blade + TailwindCSS 4 + Alpine.js |
| **Build** | Vite |
| **Rich Text** | TinyMCE 8.6 (Open Source, GPL) |
| **Image Processing** | Intervention/Image v4 (WebP + resize) |
| **Image Cropper** | Cropper.js |
| **Auth** | Custom (Laravel session-based) |
| **Roles** | Spatie `laravel-permission` (superadmin / admin / editor) |
| **Charts** | Chart.js (admin dashboard) |
| **Animations** | AOS (Animate On Scroll) |
| **Slider** | Swiper |
| **Icons** | Heroicons + Lucide |

---

## Features

### Public Site (`/`)
- Hero slider (dynamic dari admin)
- Sambutan kepala sekolah + visi/misi
- Jurusan cards (4-col grid)
- Artikel terbaru + featured
- Video embed YouTube
- Prestasi siswa
- Galeri foto (album + lightbox)
- Halaman kontak + form
- Profil: sejarah, visi-misi, fasilitas
- SEO-friendly URLs (slug-based)
- Multi-bahasa-ready (ID/EN infrastructure ada)

### Admin Panel (`/admin/*`)
- **Dashboard**: stat cards, charts (artikel per bulan, top 10 views, prestasi per tingkat)
- **CRUD** 14 modul:
  - Artikel (TinyMCE + image cropper + media library)
  - Jurusan, Ketua Jurusan, Guru & Staff
  - Slider Hero, Video, Galeri (album + foto)
  - Prestasi, Pengumuman
  - Ekstrakurikuler, Fasilitas
  - Link Terkait, Pesan Kontak
- **Settings**:
  - Pengaturan sekolah (logo, favicon, hero, sosmed, peta)
  - User management (superadmin only)
- **Media Library** (TinyMCE):
  - Browse existing files (folder tabs + search + multi-select)
  - Bulk delete (auto-skip files in use)
  - Preview & insert from TinyMCE dialog

### Image Processing
- Auto-resize per modul (artikel 1200×630, slider 1920×800, guru 400×500, dll)
- Convert to WebP (quality 82-85)
- Fit modes: `scale`, `cover`, `contain`
- Max 24 files/page in library

### Asset Protection
- **Custom Laravel route** `/uploads/{path}` (no public symlink)
- Auth-gated: login required OR `Referer` from same domain
- Direct URL paste → **403 Forbidden** (no download)
- "Open in new tab" → **403**
- Embedded in pages → **200 OK**
- Fallback to `assets/img/no-image.png` for missing files
- Bulk delete with reference check (rejects files used in 13 models)

---

## Requirements

| Komponen | Versi |
|---|---|
| PHP | ^8.3 (tested on 8.5) |
| Composer | 2.x |
| Node.js | 20.x LTS |
| NPM | 10.x |
| Database | MySQL 8 / MariaDB 10.6+ |
| Web Server | Apache (Laragon/XAMPP) / Nginx |
| PHP Extensions | `pdo_mysql`, `mbstring`, `xml`, `curl`, `gd` (v2+), `bcmath`, `zip`, `intl`, `fileinfo`, `exif` |

Enable in `php.ini`:
```ini
extension=pdo_mysql
extension=mbstring
extension=gd
extension=bcmath
extension=zip
extension=intl
extension=exif
extension=fileinfo
```

---

## Installation (Local / Laragon)

```bash
# 1. Clone repo
git clone <repo-url> smkn2beta
cd smkn2beta

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Edit .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=smkn2beta
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Create database (via phpMyAdmin / Laragon terminal)
#    CREATE DATABASE smkn2beta;

# 6. Migrate + seed (creates 3 default users)
php artisan migrate --seed

# 7. Build frontend assets
npm run build

# 8. Run dev server
php artisan serve
# Akses: http://127.0.0.1:8000
```

> **Tidak perlu `php artisan storage:link`** — project tidak pakai symlink. Asset dilayani oleh `AssetController` via route `/uploads/{path}`.

### Development Mode (HMR)

```bash
composer run dev
# Runs: serve, queue:listen, pail, vite (concurrent)
```

---

## Default Accounts (setelah seeding)

| Role | Email | Password |
|---|---|---|
| **superadmin** | `admin@smkn2pekanbaru.sch.id` | `password123` |
| **admin** | `admin2@smkn2pekanbaru.sch.id` | `password123` |
| **editor** | `editor@smkn2pekanbaru.sch.id` | `password123` |

> **WAJIB ganti password setelah first login.** Login: `http://127.0.0.1:8000/login`

### Role Permissions

| Modul | superadmin | admin | editor |
|---|---|---|---|
| Dashboard | ✓ | ✓ | ✓ |
| Artikel, Video, Galeri, Prestasi, Pengumuman | ✓ | ✓ | ✓ |
| Jurusan, Ketua Jurusan, Guru, Ekstrakurikuler, Fasilitas, Slider, Link Terkait | ✓ | ✓ | ✗ |
| Pengaturan Sekolah, User Management | ✓ | ✗ | ✗ |

---

## Routes

| File | Prefix | Fungsi |
|---|---|---|
| `routes/web.php` | `/` | Public site + login/logout |
| `routes/auth.php` | `/login`, `/register`, `/forgot-password`, dll | Auth flow |
| `routes/admin.php` | `/admin/*` | Dashboard + CRUD 14 modul + settings |

**Auth routes di-load via `bootstrap/app.php` → `then()` callback** dengan `web` middleware.

---

## Architecture

### Folder Structure
```
smkn2beta/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # 16 controllers (CRUD + Upload + Asset)
│   │   │   ├── Public/            # 9 controllers (Home, Artikel, Jurusan, dll)
│   │   │   └── AssetController.php # serves /uploads/{path} with auth
│   │   └── Middleware/AdminMiddleware.php
│   ├── Models/                    # 17 Eloquent models
│   ├── Traits/
│   │   ├── HasImageUpload.php    # resize + WebP (v4 API)
│   │   └── AjaxResponse.php      # jsonSuccess/jsonError helpers
│   └── Observers/
├── database/
│   ├── migrations/                # 20+ migrations
│   ├── seeders/                   # 17 seeders
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── public/                # 12+ blade files
│   │   ├── admin/                 # 50+ blade files (CRUD)
│   │   ├── auth/                  # login, register
│   │   ├── layouts/                # app, admin, guest
│   │   └── components/             # 6+ components (image-cropper, rich-text, dll)
│   ├── css/app.css
│   └── js/
│       ├── app.js                  # Alpine init
│       └── admin.js                # + TinyMCE 8.6 + plugins + icons + default skin
├── public/
│   ├── assets/img/                # logo, no-image.png, smk2asset copy
│   ├── build/                     # Vite output (gitignored)
│   ├── uploads/                   # VIRTUAL via Laravel route (no symlink)
│   └── index.php
├── routes/
│   ├── web.php                     # + /uploads/{path} route
│   ├── auth.php
│   └── admin.php
├── storage/
│   ├── app/public/                 # user uploads (gitignored)
│   │   ├── artikels/, jurusans/, gurus/, ..., sliders/
│   │   └── .gitkeep
│   ├── framework/                  # auto-generated (gitignored)
│   └── logs/
├── .env.example
├── .gitignore
├── composer.json
├── package.json
└── vite.config.js
```

### Key Components

| Component | Fungsi |
|---|---|
| `<x-image-cropper>` | Upload + crop + resize dengan Cropper.js, WebP output |
| `<x-rich-text>` | TinyMCE 8.6 editor (GPL, ~20 plugins) + media library button |
| `<x-image-input>` | Simple file upload dengan preview + WebP convert |
| `<x-admin.sidebar-link>` | Sidebar menu dengan icon mapping |
| `<x-public.section-title>` | Section heading public pages |

### Key Traits

**`App\Traits\HasImageUpload`** (v4 API Intervention):
```php
$this->uploadImage($file, 'artikels', 1200, 630);     // single size
$this->uploadImageVariants($file, 'artikels');         // 5 variants
$this->replaceImage($file, 'artikels', $oldPath);     // delete old
$this->resolveImageInput($request, 'gambar', $old);    // from FormData
$this->deleteImage($path);                              // cleanup
```

**`App\Traits\AjaxResponse`**:
```php
return $this->jsonSuccess('OK', ['id' => 1]);
return $this->jsonError('Failed', [], 422);
$this->wantsJson($request); // detect AJAX
```

### Asset URL Pattern

❌ ~~`asset('storage/...')`~~ (deprecated — symlink removed)  
✅ `asset('uploads/...')` — served by `AssetController`, auth + Referer gated

```php
// In controllers:
'url' => url('uploads/' . $filename),    // /uploads/artikels/xxx.webp
```

### Database Schema (high-level)

17 models: `User`, `Sekolah`, `Jurusan`, `KetuaJurusan`, `Guru`, `Artikel`, `KategoriArtikel`, `Tag`, `Video`, `KategoriVideo`, `AlbumGaleri`, `Galeri`, `Slider`, `Prestasi`, `Pengumuman`, `Ekstrakurikuler`, `Fasilitas`, `LinkTerkait`, `KontakPesan`

Plus Spatie `roles`, `permissions`, `model_has_roles` tables.

---

## Deployment

### 1. Server Prep

```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm ci
npm run build
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="SMKN 2 Pekanbaru"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://smkn2pekanbaru.sch.id

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smkn2beta
DB_USERNAME=smkn2beta_user
DB_PASSWORD=strong_password

SESSION_DRIVER=database
CACHE_STORE=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=noreply@smkn2pekanbaru.sch.id
MAIL_PASSWORD=...
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@smkn2pekanbaru.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan migrate --force
php artisan db:seed --force    # only first deploy
```

### 4. Permissions (Linux)

```bash
sudo chown -R www-data:www-data /var/www/smkn2beta
sudo find /var/www/smkn2beta -type d -exec chmod 755 {} \;
sudo find /var/www/smkn2beta -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

> **JANGAN `php artisan storage:link`** — symlink di-remove demi asset protection.

### 5. Cron / Scheduler

```cron
* * * * * cd /var/www/smkn2beta && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Apache (.htaccess) atau Nginx

**Apache (`public/.htaccess`)** — default Laravel. Web server document root = `public/`.

**Nginx:**
```nginx
server {
    listen 80;
    server_name smkn2pekanbaru.sch.id www.smkn2pekanbaru.sch.id;
    root /var/www/smkn2beta/public;
    index index.php;
    charset utf-8;
    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Asset protection: assets via /uploads/{path} route, no direct access
    # (no extra config needed — Laravel handles it)

    # SSL via Certbot
}
```

```bash
sudo certbot --nginx -d smkn2pekanbaru.sch.id -d www.smkn2pekanbaru.sch.id
```

---

## Useful Commands

```bash
# Clear all cache
php artisan optimize:clear

# Lint code
./vendor/bin/pint

# Run tests
php artisan test

# Code style
./vendor/bin/pint --test

# List all routes
php artisan route:list

# Storage info
php artisan storage:info

# Tinker
php artisan tinker

# Interactive shell
composer run dev

# Build assets (production)
npm run build

# Dev with HMR
npm run dev

# Database
php artisan migrate:fresh --seed    # reset all
php artisan db:seed                  # seed only
```

---

## Troubleshooting

### Image upload returns 500 "Call to undefined method read()"
Intervention/Image v4 API. Use `decode()` instead of `read()`. Sudah fixed di trait `HasImageUpload`.

### TinyMCE "!not found!" on icons
Add `import 'tinymce/icons/default';` di `resources/js/admin.js`. Sudah ada.

### `php artisan storage:link` is NOT needed
Project tidak pakai symlink. Asset dilayani oleh `AssetController` route `/uploads/{path}` dengan auth + Referer check.

### File `404 Not Found` di `/uploads/...`
Pastikan `storage/app/public/{folder}/{file}` exists. Placeholder files di-copy dari `public/assets/img/logo.png` ke setiap folder sub-modul.

### Image cropper popup tidak muncul
Pastikan `Cropper.js` loaded (CDN di `<x-image-cropper>` component) dan CSRF token ada.

### Error 419 CSRF
Pastikan form ada `@csrf` directive. Untuk AJAX, sertakan `X-CSRF-TOKEN` header.

### Login redirect loop
Clear cookies + cache: `php artisan optimize:clear && php artisan config:clear`

### Permission denied di `storage/logs`
```bash
chmod -R 775 storage bootstrap/cache
```

---

## License

MIT License — see [LICENSE](LICENSE).

---

## Credits

- **Framework**: [Laravel](https://laravel.com)
- **Rich Text**: [TinyMCE](https://www.tiny.cloud) (GPL v2+)
- **Image Processing**: [Intervention/Image](https://image.intervention.io)
- **Image Cropper**: [Cropper.js](https://fengyuanchen.github.io/cropperjs/)
- **Charts**: [Chart.js](https://www.chartjs.org)
- **CSS**: [Tailwind CSS](https://tailwindcss.com)
- **JS**: [Alpine.js](https://alpinejs.dev)
- **Asset source**: `@smk2asset/` (folder lokal berisi gambar, logo, ikon dari website asli)
