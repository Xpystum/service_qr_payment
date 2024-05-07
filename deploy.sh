#!/bin/bash

set -e

echo "Deploying..."

git pull origin master

php8.3 artisan down

php8.3 composer.phar install --no-dev --optimize-autoloader

php8.3 artisan migrate --force

php8.3 artisan optimize

php8.3 artisan up

echo "Done!"
