FROM php:8.2-fpm

# 必要パッケージ & PHP拡張
RUN apt-get update && apt-get install -y \
    zip unzip libicu-dev libonig-dev libzip-dev git \
 && docker-php-ext-install pdo_mysql intl zip

# ホストと同じUID/GIDのユーザーを作成（既定は1000:1000）
ARG UID=1000
ARG GID=1000
RUN groupadd -g ${GID} appgroup \
 && useradd -m -u ${UID} -g ${GID} -s /bin/bash appuser

# 作業ディレクトリ
WORKDIR /var/www

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 以後はappuserで動かす（unknown対策＆権限安定）
USER appuser
