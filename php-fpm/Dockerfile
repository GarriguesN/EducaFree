# Add PHP-FPM base image
FROM php:8.1-fpm

RUN apt-get update 
RUN apt-get install -y \
        build-essential \
        icu-devtools \
        libicu-dev \
        libzip-dev \
        zip \
        libbz2-dev \
        sendmail \
        libpng-dev \
        openssl \
        git \
        libldap2-dev \
        libxml2-dev \
        libsodium-dev \
        libxslt-dev \
        curl \
        libcurl4-openssl-dev

        
RUN docker-php-ext-install mysqli pdo pdo_mysql intl zip bcmath bz2 gd ldap soap sodium pdo pcntl xml xsl exif dom curl
RUN mkdir -p /var/www/moodledata
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /var/www/moodledata
RUN chmod -R 755 /var/www


COPY ./php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/overrides.ini
RUN echo "security.limit_extensions =" >> /usr/local/etc/php-fpm.d/docker.conf

