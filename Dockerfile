FROM wordpress
RUN chown -R www-data:www-data /var/www/html

COPY xdebug.ini "${PHP_INI_DIR}/conf.d"
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# RUN apt-get -y update && apt-get -y install vim

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer