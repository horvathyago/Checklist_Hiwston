#!/bin/bash

# Atualizar pacotes e instalar dependências
sudo apt-get update
sudo apt-get install -y php-cli php-mysql php-xml mysql-server curl

# Instalar Composer
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php

# Iniciar o serviço do MySQL
sudo service mysql start

# Criar banco de dados e usuário
sudo mysql -e "CREATE DATABASE IF NOT EXISTS my_app;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'my_app'@'localhost' IDENTIFIED BY 'secret';"
sudo mysql -e "GRANT ALL PRIVILEGES ON my_app.* TO 'my_app'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Instalar dependências do Composer
composer install

# Corrigir configuração do banco de dados
sed -i "s/'host' => 'localhost'/'host' => '127.0.0.1'/g" config/app_local.php

# Executar migrações
bin/cake migrations migrate