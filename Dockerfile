# Gunakan base image PHP dengan Apache
FROM php:8.3-apache

# Instal dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd bcmath xml zip

# Aktifkan modul Apache rewrite (penting untuk routing Laravel)
RUN a2enmod rewrite

# Perbaikan Warning: Gunakan format ENV key=value
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Salin seluruh source code proyek ke dalam container
COPY . .

# Instal Composer secara global di dalam container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Taktik Baru: Izinkan Composer berjalan sebagai root dan abaikan platform reqs sepenuhnya
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs

# Atur *permission* folder storage dan bootstrap/cache agar bisa ditulis oleh Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 untuk akses web
EXPOSE 80

# Jalankan Apache di foreground
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]