FROM php:8.2-apache

# Instalar extensões PHP necessárias para MySQL e requisições HTTP
RUN docker-php-ext-install mysqli pdo_mysql

# Habilitar mod_rewrite do Apache (necessário para o .htaccess funcionar)
RUN a2enmod rewrite

# Permitir que o Apache leia o .htaccess na pasta do projeto
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80
