FROM php:8.2-fpm-alpine

# Instala dependencias de sistema
RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    imagemagick \
    imagemagick-dev \
    ghostscript \
    curl \
    git \
    unzip \
    zip \
    nodejs \
    npm \
    bash \
    supervisor

# Configura GD antes de instalarlo
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Instala extensiones de PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    bcmath \
    exif \
    gd \
    opcache \
    zip

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia el contenido del proyecto
COPY . .

# Asigna permisos a Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
