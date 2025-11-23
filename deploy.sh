#!/bin/bash

# Navigate to project folder
cd /home/classicit/playstore.citsolution.xyz

# Pull latest code from GitHub
git reset --hard
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Log deployment
echo "$(date): Deployment done" >> /home/classicit/deploy.log
