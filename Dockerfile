FROM php:8.0

# Atualize o sistema e instale dependências do sistema e PHP
RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git libpng-dev libzip-dev libonig-dev libgmp-dev default-mysql-client && \
    docker-php-ext-install pdo_mysql gd zip gmp

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure o diretório de trabalho e copie os arquivos do projeto
WORKDIR /app
COPY . /app

# Ajuste permissões para o usuário padrão do PHP no contêiner
RUN chown -R www-data:www-data /app

# Instale dependências do projeto Laravel
RUN composer install --no-dev --optimize-autoloader

# Limpeza de cache do Laravel
RUN php artisan cache:clear && php artisan config:clear && php artisan route:clear

# Comando padrão para iniciar o servidor do Laravel
CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
