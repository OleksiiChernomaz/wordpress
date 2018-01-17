FROM oleksiichernomaz/php-fpm:7.2

RUN export WP_VERSION=4.9.2 \
    && apk add --no-cache --upgrade \
           ca-certificates \
           wget \
#install wp
&& cd /tmp/ \
    && wget https://wordpress.org/wordpress-${WP_VERSION}.tar.gz \
    && tar -xvzf ./wordpress-${WP_VERSION}.tar.gz \
    && rm ./wordpress-${WP_VERSION}.tar.gz \
    && mv ./wordpress /www \
    && chown -R www-data:www-data /www \
    && rm /www/wp-config-sample.php \
#some cleanup
&& apk del \
    wget
#inject default settings
ADD ./php/php.ini /usr/local/etc/php/conf.d/php.ini
#inject wp configurator
ADD ./www/wp-config.php /www/wp-config.php

VOLUME /www/
WORKDIR /www/

EXPOSE 9000
CMD ["php-fpm"]
