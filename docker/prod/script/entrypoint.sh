#!/bin/bash

# Проверка на существование wait-for-it.sh
# if [ ! -f "./wait-for-it.sh" ]; then
#   echo "Файл wait-for-it.sh не найден!"
#   exit 1
# fi

# Ожидание подключения к базе данных
/usr/local/bin/wait-for-it.sh db:5432 --timeout=30

php artisan config:cache

# Запуск миграций
php artisan migrate --force

php artisan install:application

# Запуск Apache
exec apache2-foreground
