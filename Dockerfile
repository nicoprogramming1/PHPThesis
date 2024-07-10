# Utiliza una imagen base de PHP con Apache
FROM php:7.4-apache

# Instala extensiones PHP necesarias (puedes agregar más según tus requerimientos)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia tu código de la aplicación al directorio web de Apache
COPY ./PP2 /var/www/html

# Expone el puerto 80 para el tráfico web
EXPOSE 80
