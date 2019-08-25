## FROM php:apache
FROM php:apache
LABEL maintainer="MKPASSWD"

## recopie appli
ENV APPROOT /var/www/html/schola
WORKDIR ${APPROOT}
RUN mkdir ${APPROOT}/logs
COPY publish ${APPROOT}/.

## Setup Apache
COPY groom-site.conf /etc/apache2/sites-available/.
RUN echo ======================
RUN apache2 -v
RUN echo ======================

RUN a2dissite 000-default.conf
RUN a2ensite schola-site.conf
RUN service apache2 restart

## Setup PHP
COPY php.ini /usr/local/etc/php/.

EXPOSE 80

