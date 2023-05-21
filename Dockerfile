FROM php:apache

# Enable "mod_headers" – http://httpd.apache.org/docs/current/mod/mod_headers.html
RUN a2enmod headers
RUN a2enmod rewrite

ENV TTNMAPPER_HOME=/opt/ttnmapper
ENV APACHE_DOCUMENT_ROOT=/opt/ttnmapper

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /opt/ttnmapper
COPY . /opt/ttnmapper