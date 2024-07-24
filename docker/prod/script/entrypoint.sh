#!/bin/bash

# Проверка на существование wait-for-it.sh
# if [ ! -f "./wait-for-it.sh" ]; then
#   echo "Файл wait-for-it.sh не найден!"
#   exit 1
# fi

# Ожидание подключения к базе данных
/usr/local/bin/wait-for-it.sh db:5432 --timeout=30

# Запуск скрипта для подготовки супервайзера
bash /usr/local/bin/start_worker.sh

# Очистка кеша
php artisan config:cache

# Запуск миграций
php artisan migrate --force

# Установка приложения
php artisan install:application

# Запуск Apache в фоновом режиме
apache2-foreground &
# Запуск supervisord
exec /usr/bin/supervisord -n


