FROM ubuntu:latest
# Establecer argumento para evitar que el proceso de instalación se detenga por el prompt interactivo
ARG DEBIAN_FRONTEND=noninteractive
# Actualizar e instalar dependencias
RUN apt-get update && \
    apt-get upgrade -y && \
    echo "9\n28" | apt-get install -y \
    php \
    php-all-dev \
    php-curl \
    php-mysql \
    composer \
    npm \
    apache2 \
    net-tools \
    nano \
    curl \
    git \
    libapache2-mod-php
# Instalar NVM y Node.js
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash \
    && . ~/.nvm/nvm.sh \
    && nvm install --lts
# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer
# Habilitar el módulo PHP 8.1 de Apache
RUN a2enmod php8.3 && \
    a2enmod rewrite && \
    service apache2 restart
# Clonar el repositorio y realizar configuraciones adicionales
WORKDIR /var/www/html
# Exponer el puerto 80 para Apache
EXPOSE 80
EXPOSE 8000
# Comando para ejecutar la aplicación cuando se inicie el contenedor
CMD ["apache2ctl", "-D", "FOREGROUND"]
