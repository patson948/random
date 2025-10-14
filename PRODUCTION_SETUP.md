# Production Setup Guide

## 🚀 Deploying to Production

This guide will help you set up your e-commerce platform in production **without demo/seed data**.

---

## Step 1: Environment Configuration

1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Update these critical settings:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   DB_CONNECTION=mysql
   DB_HOST=your-database-host
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_secure_password
   ```

3. Generate application key:
   ```bash
   php artisan key:generate
   ```

---

## Step 2: Database Setup

1. Run migrations (creates tables without seed data):
   ```bash
   php artisan migrate --force
   ```

2. *(Optional)* Create initial admin user:
   ```bash
   # Edit database/seeders/ProductionSeeder.php first to set your email/password
   php artisan db:seed --class=ProductionSeeder
   ```

   Or create admin user via tinker:
   ```bash
   php artisan tinker
   ```
   ```php
   User::create([
       'name' => 'Admin',
       'email' => 'admin@yourcompany.com',
       'password' => Hash::make('YourSecurePassword'),
       'role' => 'admin',
       'is_active' => true,
   ]);
   ```

---

## Step 3: Initial Configuration via Admin Panel

Login to admin panel at: `https://yourdomain.com/login`

### Create Home Sections (Optional - has fallbacks)

1. Go to **Admin → Home Sections** (`/admin/home-sections`)
2. Click **Create New Section**
3. Create sections as needed:

   **Hero Slide Example:**
   - Type: Hero Slide
   - Title: "Welcome to Our Store"
   - Description: "Shop the best products"
   - Button Text: "Shop Now"
   - Button Link: "/search"
   - Order: 1

   **Top Bar Example:**
   - Type: Top Bar Message
   - Title: "Free shipping on orders over $50"
   - Order: 1

> **Note:** If you don't create home sections, the app will:
> - Generate hero slides automatically from your products
> - Hide CTA banners and top bar (they're optional)

### Create Categories

1. Go to **Admin → Categories** (`/admin/categories`)
2. Create your product categories
3. Categories are required for creating products

### Create Vendors (if multi-vendor)

1. Go to **Admin → Vendors** (`/admin/vendors`)
2. Approve vendor applications as they come in

---

## Step 4: Optimization for Production

1. Cache configuration:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. Run npm build:
   ```bash
   npm run build
   ```

3. Set proper permissions:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. Link storage:
   ```bash
   php artisan storage:link
   ```

---

## Step 5: Security Checklist

- [ ] Change all default passwords
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Configure SSL certificate (HTTPS)
- [ ] Set up proper file permissions (no 777)
- [ ] Configure CORS properly in `config/cors.php`
- [ ] Set up rate limiting in `app/Http/Kernel.php`
- [ ] Remove or secure debug routes (check `routes/web.php` lines 81-115)
- [ ] Configure backup strategy
- [ ] Set up monitoring and error logging

---

## Step 6: Payment Integration

Configure payment gateway in `.env`:

```env
# Lenco Mobile Money (example)
LENCO_API_KEY=your_api_key
LENCO_SECRET_KEY=your_secret_key
LENCO_API_URL=https://api.lenco.co
```

---

## Step 7: Email Configuration

Configure email for order notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourcompany.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourcompany.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🎯 Production Workflow

### For Store Owners:
1. Login as admin
2. Create/approve vendors
3. Create categories
4. Manage home sections (optional)
5. Monitor orders and transactions

### For Vendors:
1. Register and create vendor account
2. Wait for admin approval
3. Add products to their store
4. Manage orders

### For Customers:
1. Browse products
2. Add to cart and checkout
3. Track orders

---

## 🔧 Maintenance Commands

```bash
# Clear all caches
php artisan optimize:clear

# Re-cache for performance
php artisan optimize

# View logs
tail -f storage/logs/laravel.log

# Run queue workers (for background jobs)
php artisan queue:work

# Monitor queue
php artisan queue:monitor
```

---

## ⚠️ Important Notes

### DO NOT Run These in Production:
```bash
# ❌ These contain demo data
php artisan db:seed
php artisan migrate:fresh --seed
```

### Only Run These:
```bash
# ✅ Production-safe
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder  # Optional, creates admin only
```

---

## 📞 Troubleshooting

### Home page shows no products?
- The app will work fine with empty database
- Hero slides will show placeholders until you add products
- Add products via Admin or Vendor panel

### Can't login as admin?
- Run `ProductionSeeder` to create admin account
- Or create manually via tinker (see Step 2)

### Images not showing?
```bash
php artisan storage:link
```

### Performance issues?
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔄 Updates & Migrations

When deploying updates:

```bash
# Backup database first!

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Run new migrations (if any)
php artisan migrate --force

# Clear and re-cache
php artisan optimize:clear
php artisan optimize
```

---

## 📊 Monitoring

- Check `storage/logs/laravel.log` for errors
- Monitor database performance
- Set up application monitoring (Sentry, Bugsnag, etc.)
- Configure uptime monitoring

---

**Need Help?** Check Laravel documentation: https://laravel.com/docs

