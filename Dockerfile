FROM php:8.3-apache

# set main params
ARG BUILD_ARGUMENT_ENV=prod
# ENV ENV=$BUILD_ARGUMENT_ENV
ENV ENV=example
ENV APP_HOME /var/www/html
ARG HOST_UID=1000
ARG HOST_GID=1000
ENV USERNAME=www-data
ARG INSIDE_DOCKER_CONTAINER=1
ENV INSIDE_DOCKER_CONTAINER=$INSIDE_DOCKER_CONTAINER
ARG XDEBUG_CONFIG=main
ENV XDEBUG_CONFIG=$XDEBUG_CONFIG
ARG XDEBUG_VERSION=3.3.1
ENV XDEBUG_VERSION=$XDEBUG_VERSION

# check environment
RUN if [ "$BUILD_ARGUMENT_ENV" = "default" ]; then echo "Set BUILD_ARGUMENT_ENV in docker build-args like --build-arg BUILD_ARGUMENT_ENV=dev" && exit 2; \
    elif [ "$BUILD_ARGUMENT_ENV" = "dev" ]; then echo "Building development environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "test" ]; then echo "Building test environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "staging" ]; then echo "Building staging environment."; \
    elif [ "$BUILD_ARGUMENT_ENV" = "prod" ]; then echo "Building production environment."; \
    else echo "Set correct BUILD_ARGUMENT_ENV in docker build-args like --build-arg BUILD_ARGUMENT_ENV=dev. Available choices are dev,test,staging,prod." && exit 2; \
    fi

# install all the dependencies and enable PHP modules
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
        supervisor \
        procps \
        git \
        unzip \
        libicu-dev \
        zlib1g-dev \
        libxml2 \
        libxml2-dev \
        libreadline-dev \
        supervisor \
        cron \
        sudo \
        libzip-dev \
        libpq-dev \
        libhiredis-dev \
        postgresql-client \
        iputils-ping \
    && docker-php-ext-configure intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install \
        pdo_pgsql \
        sockets \
        intl \
        opcache \
        zip \
    && rm -rf /tmp/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# отключить сайт по умолчанию и удалить все файлы по умолчанию внутри APP_HOME
RUN a2dissite 000-default.conf
RUN rm -r $APP_HOME

# Копирование скрипта wait-for-it.sh в контейнер - скрипт нужен для того что бы сначал запустилось БД и только после него подали миграции
# COPY wait-for-it.sh /usr/local/bin/wait-for-it

# создать корень документа, исправить разрешения для пользователя www-data и сменить владельца на www-data
RUN mkdir -p $APP_HOME/public && \
    mkdir -p /home/$USERNAME && chown $USERNAME:$USERNAME /home/$USERNAME \
    && usermod -o -u $HOST_UID $USERNAME -d /home/$USERNAME \
    && groupmod -o -g $HOST_GID $USERNAME \
    && chown -R ${USERNAME}:${USERNAME} $APP_HOME

# ставим конфигурацию Apache и php для Laravel, включаем сайты
COPY ./docker/general/laravel.conf /etc/apache2/sites-available/laravel.conf
COPY ./docker/general/laravel-ssl.conf /etc/apache2/sites-available/laravel-ssl.conf
RUN a2ensite laravel.conf && a2ensite laravel-ssl
COPY ./docker/$BUILD_ARGUMENT_ENV/php.ini /usr/local/etc/php/php.ini

# включаем модули Apache
RUN a2enmod rewrite
RUN a2enmod ssl

# установить Xdebug в случае, если среда разработки/тестирования
COPY ./docker/general/do_we_need_xdebug.sh /tmp/
COPY ./docker/dev/xdebug-${XDEBUG_CONFIG}.ini /tmp/xdebug.ini
RUN chmod u+x /tmp/do_we_need_xdebug.sh && /tmp/do_we_need_xdebug.sh

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1


# add supervisor
# RUN mkdir -p /var/log/supervisor
# COPY --chown=root:root ./docker/general/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# COPY --chown=root:crontab ./docker/general/cron /var/spool/cron/crontabs/root
# RUN chmod 0600 /var/spool/cron/crontabs/root

# Скопируйте конфиг Supervisor
COPY docker/prod/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# generate certificates
# TODO: change it and make additional logic for production environment
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=example.com"

# set working directory
WORKDIR $APP_HOME

USER ${USERNAME}

# копируем исходные файлы и файл конфигурации
COPY --chown=${USERNAME}:${USERNAME} . $APP_HOME/
COPY --chown=${USERNAME}:${USERNAME} .env.$ENV $APP_HOME/.env

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Обновите Composer до последней снимка версии
RUN composer self-update

USER root


#копируем скрипты
    #скрипт точки входа программы (запуск миграции, настройка приложения и т.д)
COPY docker/prod/script/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY docker/prod/script/wait-for-it.sh /usr/local/bin/wait-for-it.sh
    #подготовка к запуску супервайзера
COPY docker/prod/script/start_worker.sh /usr/local/bin/start_worker.sh


# Задайте скрипт точки входа
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 80

#на таком порте работает
# docker run -p 5000:80 my-php-app
