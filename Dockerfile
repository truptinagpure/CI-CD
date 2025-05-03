# Use PHP 7.1.27 with Apache
FROM php:7.1.27-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite for CodeIgniter
RUN a2enmod rewrite

# Set working directory to somaiya
WORKDIR /var/www/html/somaiya

# Copy project files from your local machine into the container
COPY . /var/www/html/somaiya

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/somaiya \
    && chmod -R 755 /var/www/html/somaiya

# Expose Apache port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
