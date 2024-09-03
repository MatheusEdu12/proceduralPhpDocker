# Use uma imagem do PHP com suporte a SQLite
FROM php:8.2-cli

# Instale dependências necessárias para compilar o SQLite mais recente
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite

# Limpe os arquivos temporários de instalação
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia o arquivo index.php para o container
COPY index.php /var/www/html/index.php

# Define o diretório de trabalho
WORKDIR /var/www/html

# Comando para rodar o servidor embutido do PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
