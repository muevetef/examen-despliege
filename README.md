# Proyecto Trastopop

Este proyecto es una aplicación web construida con PHP, utilizando Apache como servidor web, MySQL como base de datos y phpMyAdmin para la administración de la base de datos. El despliegue se realiza utilizando Docker Compose.

## Prerrequisitos

- Docker
- Docker Compose

## Instalación de Composer en Debian

Composer es un administrador de dependencias para PHP. Para instalar Composer en un sistema Debian, sigue estos pasos:

1. **Actualiza el sistema:**

    ```bash
    sudo apt update
    sudo apt upgrade
    ```

2. **Instala las dependencias necesarias:**

    ```bash
    sudo apt install curl php-cli php-mbstring git unzip
    ```

3. **Descarga e instala Composer:**

    ```bash
    cd ~
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    ```

4. **Verifica la integridad del instalador:**

    ```bash
    HASH=`curl -sS https://composer.github.io/installer.sig`
    php -r "if (hash_file('sha384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    ```

    Deberías ver "Installer verified" si el instalador es seguro para ejecutar.

5. **Instala Composer globalmente:**

    ```bash
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    ```

6. **Verifica la instalación:**

    ```bash
    composer --version
    ```

    Deberías ver la versión de Composer instalada.

## Despliegue del Proyecto con Docker Compose

Sigue estos pasos para desplegar el proyecto utilizando Docker Compose:

1. **Clona el repositorio:**

    ```bash
    git clone https://github.com/tu-usuario/trastopop.git
    cd trastopop
    ```

2. **Revisa y adapta el archivo `docker-compose.yml`:**

    ```yaml
    services:
    apache:
        build:
        context: .
        ports:
        - "80:80"
        volumes:
        - ./trastopop:/var/www/html
        depends_on:
        - mysql

    mysql:
        image: mysql:latest
        environment:
        MYSQL_ROOT_PASSWORD: toor
        MYSQL_DATABASE: trastopopdb
        MYSQL_USER: test
        MYSQL_PASSWORD: 1234
        MYSQL_CHARSET: utf8mb4
        MYSQL_COLLATION: utf8mb4_unicode_ci
        # Forzar utf-8 al cliente de mysql https://github.com/docker-library/mysql/issues/131#issuecomment-248412170
        LANG: C.UTF-8
        volumes:
        - ./mysql/data:/var/lib/mysql
        - ./mysql/initdb:/docker-entrypoint-initdb.d
    phpmyadmin:
        image: phpmyadmin/phpmyadmin:latest
        links:
        - mysql:db
        ports:
        - "8080:80"
        environment:
        MYSQL_USERNAME: root
        MYSQL_ROOT_PASSWORD: toor

    ```

3. **Revisa y adapta el archivo `Dockerfile`:**

    ```dockerfile
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

    # Ajustar permisos
    RUN chown -R www-data:www-data /var/www/html \
        && chmod -R 755 /var/www/html

    ```

4. **Revisa y adapta el archivo de configuración del VirtualHost (`virtualhost.conf`):**

    ```apache
    <VirtualHost *:80>
        DocumentRoot /var/www/html/public

        <Directory /var/www/html/public>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```

5. **Inicializa y construye los contenedores:**

    ```bash
    docker-compose up --build -d
    ```

6. **Verifica el despliegue:**

    - Accede a tu aplicación en `http://localhost`.
    - Accede a phpMyAdmin en `http://localhost:8080`.

## Notas adicionales

- Asegúrate de tener Docker y Docker Compose correctamente instalados en tu sistema.
- Si encuentras problemas de permisos, ajusta los permisos de los archivos y directorios relevantes.
- Para detener los contenedores, usa el comando:

    ```bash
    docker-compose down
    ```

¡Eso es todo! Ahora deberías tener tu aplicación Trastopop desplegada y corriendo en tu entorno local utilizando Docker Compose.
