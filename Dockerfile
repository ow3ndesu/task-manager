FROM php:8.1-apache
COPY ./src /var/www/html/task-manager
RUN docker-php-ext-install pdo pdo_mysql
EXPOSE 81
