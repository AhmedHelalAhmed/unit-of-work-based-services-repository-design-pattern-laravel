FROM php:8.0.0-apache

RUN apt-get update -yqq && \
  apt-get install -y apt-utils zip unzip && \
  apt-get install -y nano && \
  apt-get install -y git && \
  apt-get install -y nodejs && \
  apt-get install -y npm && \
  apt-get install -y libzip-dev && \
  a2enmod rewrite && \
  docker-php-ext-install mysqli pdo pdo_mysql && \
  docker-php-ext-configure zip && \
  docker-php-ext-install zip && \
  rm -rf /var/lib/apt/lists/*

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

 COPY /app/Scripts/default.conf /etc/apache2/sites-enabled/000-default.conf

ARG user
ARG uid
RUN useradd -u $uid $user
RUN mkdir /home/$user/
RUN chown -R $user:$user /var/www/html
RUN chown -R $user:$user /home/$user/
USER $user

WORKDIR /var/www/app

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

EXPOSE 80
