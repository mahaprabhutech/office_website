# 7. Production Deployment

Recommended:

- `api.yourdomain.com` for Laravel
- `www.yourdomain.com` for React

## Laravel

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set the web root to `backend/public`.

## React

```bash
npm ci
npm run build
```

Deploy `frontend/dist` and configure SPA fallback to `index.html`.

## Safety

Use HTTPS, `APP_DEBUG=false`, strong passwords, restricted CORS, daily backups, correct storage permissions and production SMTP.
