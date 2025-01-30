# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang diperlukan dan dependensi lainnya
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    wget \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Unduh dan pasang APM agent Elastic
RUN wget https://github.com/elastic/apm-agent-php/releases/download/v1.15.0/apm-agent-php_1.15.0_all.deb \
    && dpkg -i apm-agent-php_1.15.0_all.deb \
    && rm apm-agent-php_1.15.0_all.deb

# Salin konfigurasi PHP
COPY ./conf/php.ini /usr/local/etc/php/php.ini

# Aktifkan modul Apache Rewrite
RUN a2enmod rewrite

# Set direktori kerja
WORKDIR /var/www/html

# Salin file aplikasi ke dalam container
COPY . /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies menggunakan Composer
RUN composer install --no-dev --optimize-autoloader

# Restart Apache untuk memastikan semua konfigurasi diterapkan
RUN service apache2 restart

# Beri permission pada folder tertentu (jika diperlukan)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 untuk Apache
EXPOSE 80

# Jalankan Apache saat container dimulai
CMD ["apache2-foreground"]