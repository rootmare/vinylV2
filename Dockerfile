FROM php:8.2-apache

# Fix MPM conflict
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80