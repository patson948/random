#!/bin/bash

# ShopHub Deployment Script
# This script automates the deployment process for ShopHub

set -e  # Exit on error

echo "🚀 Starting ShopHub Deployment..."
echo "=================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Functions
function info() {
    echo -e "${GREEN}✓${NC} $1"
}

function warn() {
    echo -e "${YELLOW}⚠${NC} $1"
}

function error() {
    echo -e "${RED}✗${NC} $1"
}

# Check if .env exists
if [ ! -f .env ]; then
    error ".env file not found! Please create it from .env.example"
    exit 1
fi

# 1. Enable maintenance mode
info "Enabling maintenance mode..."
php artisan down || true

# 2. Pull latest code
info "Pulling latest code from repository..."
git pull origin main

# 3. Install/Update dependencies
info "Installing composer dependencies..."
composer install --optimize-autoloader --no-dev

info "Installing npm dependencies..."
npm install

# 4. Build assets
info "Building frontend assets..."
npm run build

# 5. Clear old caches
info "Clearing old caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 6. Run migrations
info "Running database migrations..."
php artisan migrate --force

# 7. Optimize application
info "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 8. Link storage (if not already linked)
info "Linking storage..."
php artisan storage:link || true

# 9. Set permissions
info "Setting permissions..."
chmod -R 755 storage bootstrap/cache

# 10. Restart queue workers
info "Restarting queue workers..."
php artisan queue:restart

# 11. Disable maintenance mode
info "Disabling maintenance mode..."
php artisan up

echo ""
echo "=================================="
echo -e "${GREEN}✓ Deployment completed successfully!${NC}"
echo "=================================="
echo ""
echo "Next steps:"
echo "1. Check logs: tail -f storage/logs/laravel.log"
echo "2. Monitor queue: php artisan queue:work --verbose"
echo "3. Test critical features"
echo "4. Monitor error tracking dashboard"
echo ""

