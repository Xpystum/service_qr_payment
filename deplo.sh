#!/bin/bash

set -e

echo "Deploying..."

git pull origin master

php 8.3 artisan down

php 8.3 composer.phar install --no-dev --optimize-autoloader

php 8.3 artisan migrate --force

php 8.3 artisan optimize

php 8.3 artisan up

echo "Done!"
