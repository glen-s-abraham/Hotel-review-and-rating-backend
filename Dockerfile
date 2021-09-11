FROM php:7.4

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
RUN apt-get clean && rm -rf /var/lib/apt/lists/*    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin \
    --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
WORKDIR /app
COPY ./src /app
RUN composer install
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0
