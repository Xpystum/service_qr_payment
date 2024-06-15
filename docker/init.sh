#!/bin/bash

# Проверка подключения к базе данных
until php artisan migrate:status > /dev/null 2>&1; do
    >&2 echo "База данных недоступна - ожидаем..."
    sleep 60
done

# Запуск миграций
php artisan migrate --force

# Запуск основной команды
exec "$@"
