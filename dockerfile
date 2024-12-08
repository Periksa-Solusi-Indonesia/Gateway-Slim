# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

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

# Beri permission pada folder tertentu (jika diperlukan)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 untuk Apache
EXPOSE 80

# Jalankan Apache saat container dimulai
CMD ["apache2-foreground"]