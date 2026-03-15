# ClydePixel

Laravel 11-based order management platform with role-based access (superadmin, admin, client), dynamic order fields, and email notifications.

## Requirements

- PHP 8.2+
- Composer 2+
- Node.js 18+
- MySQL 8+

## Local Setup

1. Install PHP dependencies.

```bash
composer install
```

2. Install frontend dependencies.

```bash
npm install
```

3. Create environment file and set values.

```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations and seed admin users.

```bash
php artisan migrate
php artisan db:seed
```

5. Build assets.

```bash
npm run build
```

## Deployment Checklist

1. Configure production `.env`.
2. Set `APP_ENV=production` and `APP_DEBUG=false`.
3. Configure MySQL connection and SMTP credentials.
4. Ensure writable permissions for `storage/` and `bootstrap/cache/`.
5. Point web server document root to `public/`.

## One-Command Deploy (Composer Script)

Run after pulling latest code and installing dependencies:

```bash
composer run deploy
```

This runs:

1. `php artisan optimize:clear`
2. `php artisan migrate --force`
3. `php artisan config:cache`
4. `php artisan route:cache`
5. `php artisan view:cache`

## Manual Production Commands

```bash
php artisan down
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan up
```

## Post-Deploy Verification

1. Run health check pages (`/`, `/login`) in browser.
2. Verify new order creation and status update flow.
3. Verify order list timer rendering.
4. Verify mail send with valid SMTP credentials.

## Notes

- If you run tests after production cache commands, clear optimized caches first:

```bash
php artisan optimize:clear
php artisan test
```
