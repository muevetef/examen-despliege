FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql
    
# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el archivo de configuración del VirtualHost
COPY virtualhost.conf /etc/apache2/sites-available/000-default.conf

# Habilitar los módulos necesarios
RUN a2enmod rewrite

# Copiar el proyecto
COPY trastopop /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Ejecutar composer install
RUN composer install

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
