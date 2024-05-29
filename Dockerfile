# Используйте официальный образ PHP с Apache
FROM php:8.3-apache

# Установите расширения PHP, необходимые для Laravel
RUN apt-get update && apt-get install -y
        libpq-dev
        libpng-dev
        libonig-dev
        libxml2-dev
        zip
        unzip
        git
        curl
    && docker-php-ext-install
        pdo_pgsql
        pgsql
        mbstring
        exif
        pcntl
        bcmath
        gd
        soap
        zip

# Включите модуль Apache Rewrite для поддержки маршрутизации Laravel
RUN a2enmod rewrite

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируйте исходный код Laravel в контейнер
COPY . /var/www/html

# Установите зависимости Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Настройте права доступа к файлам и каталогам
RUN chown -R www-data:www-data /var/www/html
    && chmod -R 755 /var/www/html/storage
    && chmod -R 755 /var/www/html/bootstrap/cache

# Откройте порт 80 для входящих соединений
EXPOSE 90

# Запустите Apache в фоновом режиме
CMD ["apache2-foreground"]
