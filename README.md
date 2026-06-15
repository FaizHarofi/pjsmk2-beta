# WebSMKN2 Beta

Project Test Website **SMKN 2 Beta** — platform informasi sekolah berbasis Laravel 13 dengan panel admin, manajemen konten, dan role-based access control.

---

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.3+)
- **Auth**: Laravel Breeze
- **Roles & Permissions**: Spatie `laravel-permission`
- **Sluggable**: Spatie `laravel-sluggable`
- **Image Processing**: Intervention/Image v4
- **Frontend**: Tailwind CSS v4, Alpine.js, Vite
- **UI Libs**: Swiper (slider), AOS (animasi), Chart.js, Lucide icons

---

## Requirements

Pastikan server memenuhi:

| Komponen   | Versi                                    |
| ---------- | ---------------------------------------- |
| PHP        | ^8.3                                     |
| Composer   | 2.x                                      |
| Node.js    | 20.x LTS                                 |
| NPM        | 10.x                                     |
| Database   | MySQL 8 / MariaDB 10.6+ / PostgreSQL 14+ |
| Web Server | Apache / Nginx                           |

PHP extensions wajib: `mbstring`, `xml`, `curl`, `gd`/`imagick`, `bcmath`, `pdo_mysql`, `zip`, `intl`.

---

## Installation (Local)

```bash
# 1. Clone repo
git clone <repo-url> websmk2beta
cd websmk2beta

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=websmk2beta
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Migrasi + seeder
php artisan migrate --seed

# 6. Storage link
php artisan storage:link

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

Akses: `http://127.0.0.1:8000`

### Mode Development (HMR)

```bash
composer run dev
```

Menjalankan `serve`, `queue:listen`, `pail`, dan `vite` secara concurrent.

---

## Deployment (Production)

### 1. Server Prep

```bash
# Pull ke server
git pull origin main

# Install deps (no dev)
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
APP_NAME="WebSMKN2 Beta"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://smkn2beta.sch.id

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=websmk2beta
DB_USERNAME=websmk2beta_user
DB_PASSWORD=strong_password

SESSION_DRIVER=database
CACHE_STORE=redis        # opsional, direkomendasikan
QUEUE_CONNECTION=redis   # opsional

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@smkn2beta.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan migrate --force
php artisan storage:link
php artisan db:seed --force   # hanya first deploy
```

### 4. Permissions (Linux)

```bash
sudo chown -R www-data:www-data /var/www/websmk2beta
sudo find /var/www/websmk2beta -type d -exec chmod 755 {} \;
sudo find /var/www/websmk2beta -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

### 5. Cron / Scheduler

Tambahkan ke crontab user web server:

```cron
* * * * * cd /var/www/websmk2beta && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Queue Worker (Systemd)

Buat `/etc/systemd/system/websmk2beta-worker.service`:

```ini
[Unit]
Description=WebSMKN2 Beta Queue Worker
After=redis-server.service

[Service]
User=www-data
Group=www-data
Restart=always
WorkingDirectory=/var/www/websmk2beta
ExecStart=/usr/bin/php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl enable --now websmk2beta-worker.service
```

---

## Nginx Config (contoh)

```nginx
server {
    listen 80;
    server_name smkn2beta.sch.id www.smkn2beta.sch.id;
    root /var/www/websmk2beta/public;

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

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # SSL handled by Certbot
}
```

Aktifkan SSL:

```bash
sudo certbot --nginx -d smkn2beta.sch.id -d www.smkn2beta.sch.id
```

---

## Routes Overview

| File               | Prefix     | Fungsi                                        |
| ------------------ | ---------- | --------------------------------------------- |
| `routes/web.php`   | `/`        | Public site (beranda, profil, berita, galeri) |
| `routes/auth.php`  | `/auth/*`  | Breeze: login, register, forgot password      |
| `routes/admin.php` | `/admin/*` | Dashboard admin, CRUD konten, kelola user     |

---

## Default Admin (setelah seeding)

```
Email   : admin@smkn2beta.sch.id
Pass    : password
```

> **Wajib ganti password setelah first login.**

---

## Useful Commands

```bash
# Clear all cache
php artisan optimize:clear

# Lint kode
./vendor/bin/pint

# Run test
php artisan test

# Storage symlink
php artisan storage:link

# Reset semua cache
php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

---

## License

MIT License — see [LICENSE](LICENSE).
