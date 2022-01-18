FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    tesseract-ocr \
    poppler-utils \
    zlib1g-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets zip xml iconv simplexml

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# add memory to php

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
#RUN sed -i 's/memory_limit.*$/memory_limit = 512M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/memory_limit.*$/memory_limit = -1/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/upload_max_filesize.*$/upload_max_filesize = 100M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/post_max_size.*$/post_max_size = 100M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/max_execution_time.*$/max_execution_time = 600/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/max_input_time.*$/max_input_time = -1/g' $PHP_INI_DIR/php.ini

# Install redis
#RUN pecl install -o -f redis \
#    &&  rm -rf /tmp/pear \
#    &&  docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

USER $user
