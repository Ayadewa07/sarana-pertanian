FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set proper permissions for JSON data storage & image upload directory
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/admin/data \
    && chmod -R 777 /var/www/html/gambar

EXPOSE 80
CMD ["apache2-foreground"]
