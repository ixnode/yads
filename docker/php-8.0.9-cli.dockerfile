# Use PHP 8.0.9 image
FROM php:8.0.9-cli

# Working dir
WORKDIR /var/www/html

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Add opcache.ini
COPY conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Use the default production configuration
RUN sed -i "s/expose_php = .*/expose_php = Off/" "$PHP_INI_DIR/php.ini" && \
    sed -i -e "s/^ *upload_max_filesize.*/upload_max_filesize = 40MB/g" "$PHP_INI_DIR/php.ini"

# Install applications
RUN apt-get update && apt-get install -y \
    wget \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    zip \
    unzip \
    cron \
    imagemagick

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install php extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mysqli pdo pdo_mysql zip intl opcache soap

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.1.5

# Install symfony cli
RUN wget https://get.symfony.com/cli/installer -O - | bash

# Install symfony cli globally
RUN mv /root/.symfony/bin/symfony /usr/local/bin/.
