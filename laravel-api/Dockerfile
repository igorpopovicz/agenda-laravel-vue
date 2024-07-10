# Use a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale as dependências do Laravel
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        unzip \
        && docker-php-ext-install zip pdo_mysql

# Copie os arquivos do projeto para o contêiner
COPY . /var/www/html

# Configure o Apache para servir o Laravel
RUN a2enmod rewrite

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Executar o Composer Install para instalar as dependências do Laravel
RUN composer install --no-interaction --no-scripts --no-suggest

# Rodar as migrações do Laravel
RUN php artisan migrate --force

# Exponha a porta 8000 do contêiner
EXPOSE 8000

# Comando para iniciar o servidor do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
