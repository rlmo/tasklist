FROM wyveo/nginx-php-fpm

COPY ./ /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html

RUN ln -s public html
RUN apt update;
RUN yes N | apt install -y php8.1-sqlite3;
RUN cp .env.example .env;
RUN composer install;
RUN php artisan key:generate;
RUN php artisan migrate;

CMD /start.sh

EXPOSE 8000