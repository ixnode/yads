# Use PHP 8.0.9 image
FROM php:8.0.9-apache

# Working dir
WORKDIR /var/www/html

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Add opcache.ini
COPY conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Use the default production configuration
RUN sed -i "s/expose_php = .*/expose_php = Off/" "$PHP_INI_DIR/php.ini" && \
    sed -i -e "s/^ *upload_max_filesize.*/upload_max_filesize = 40M/g" "$PHP_INI_DIR/php.ini"

# Set some security settings
RUN sed -i "s/^ServerTokens .*/ServerTokens Prod/" "/etc/apache2/conf-available/security.conf" && \
    sed -i "s/^ServerSignature .*/ServerSignature Off/" "/etc/apache2/conf-available/security.conf"

# Install applications
RUN apt-get update && apt-get install -y \
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
    imagemagick

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mysqli pdo pdo_mysql zip soap

# Change document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Activate and deactivate some apache modules
RUN a2enmod deflate rewrite headers mime expires && \
    a2dismod status

# Add environment variables
RUN sed -ri -e 's!</VirtualHost>!\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        # Add db environment variables\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_HOST    "${ENV_DB_HOST}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_PORT    "${ENV_DB_PORT}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_USER    "${ENV_DB_USER}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_PASS    "${ENV_DB_PASS}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_NAME    "${ENV_DB_NAME}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_VERSION "${ENV_DB_VERSION}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_DB_DRIVER  "${ENV_DB_DRIVER}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    \
    sed -ri -e 's!</VirtualHost>!\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        # Add mail environment variables\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_MAIL_SERVER_TRANSPORT "${ENV_MAIL_SERVER_TRANSPORT}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_MAIL_SERVER_HOST "${ENV_MAIL_SERVER_HOST}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_MAIL_SERVER_PORT "${ENV_MAIL_SERVER_PORT}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    \
    sed -ri -e 's!</VirtualHost>!\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        # Add system environment variables\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_SYSTEM_CONTEXT "${ENV_SYSTEM_CONTEXT}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!</VirtualHost>!        SetEnv ENV_SYSTEM_PROXY_HOST "${ENV_SYSTEM_PROXY_HOST}"\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf


