# Production Deployment Checklist

## Pre-Deployment

- [ ] Review and update `.env` file
  - [ ] `APP_ENV=production`
  - [ ] `APP_DEBUG=false`
  - [ ] `APP_URL` set correctly
  - [ ] Database credentials configured
  - [ ] Mail settings configured
  - [ ] Payment gateway keys configured

- [ ] Remove debug routes from `routes/web.php` (lines 81-143)
  - [ ] Remove `/social-auth-test`
  - [ ] Remove `/facebook-debug`
  - [ ] Remove all `*-demo` routes
  - Or comment them out with middleware restrictions

- [ ] Update `ProductionSeeder.php` with your admin credentials
  - [ ] Change email address
  - [ ] Change password

## Deployment Commands

```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Build frontend assets
npm install
npm run build

# 4. Run migrations (first time only)
php artisan migrate --force

# 5. Create admin user (first time only)
php artisan db:seed --class=ProductionSeeder

# 6. Link storage
php artisan storage:link

# 7. Optimize application
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Set permissions
chmod -R 775 storage bootstrap/cache
```

## Post-Deployment

- [ ] Test login with admin credentials
- [ ] Create initial categories via admin panel
- [ ] (Optional) Create home sections via admin panel
- [ ] Test product creation
- [ ] Test checkout flow
- [ ] Test payment processing
- [ ] Verify email notifications work

## Security

- [ ] SSL certificate installed and working
- [ ] File permissions set correctly (no 777)
- [ ] Database backups configured
- [ ] Error logging configured (Sentry, etc.)
- [ ] Rate limiting enabled
- [ ] CORS configured properly

## Performance

- [ ] Caches enabled (config, route, view)
- [ ] Queue worker running (if using queues)
- [ ] CDN configured for assets (if applicable)
- [ ] Database indexes optimized
- [ ] Redis/Memcached configured (if applicable)

## Monitoring

- [ ] Application monitoring setup
- [ ] Uptime monitoring setup
- [ ] Log monitoring setup
- [ ] Performance monitoring setup

## Documentation

- [ ] Admin credentials documented (securely)
- [ ] Deployment process documented
- [ ] Backup/restore process documented
- [ ] Emergency contact list created

---

## Quick Commands Reference

### Clear everything:
```bash
php artisan optimize:clear
```

### Re-optimize:
```bash
php artisan optimize
```

### View logs:
```bash
tail -f storage/logs/laravel.log
```

### Create admin user manually:
```bash
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin', 'is_active' => true]);
```

---

## ⚠️ NEVER Run in Production

```bash
# These commands will wipe your database!
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan db:seed  # (except ProductionSeeder)
```

