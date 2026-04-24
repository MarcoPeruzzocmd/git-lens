# =============================================================================
# 📁 ARQUIVO: backend/Dockerfile
# =============================================================================
#
# ▸ O QUE É ESTE ARQUIVO?
#   É a "receita" para construir a imagem Docker do backend.
#   O Docker lê este arquivo e cria um container com tudo que o PHP precisa.
#
# ▸ QUAL A FUNÇÃO DELE NO PROJETO?
#   Criar um ambiente isolado com Apache + PHP + extensões MySQL.
#   Assim, qualquer pessoa que clonar o projeto consegue rodar sem
#   instalar PHP, Apache ou MySQL na própria máquina.
#
# ▸ O QUE PRECISO FAZER AQUI?
#
#   1. ESCOLHER A IMAGEM BASE:
#      Usar: FROM php:8.2-apache
#      Isso já vem com PHP 8.2 e Apache pré-configurados.
#
#   2. INSTALAR EXTENSÕES PHP PARA MYSQL:
#      O PHP não vem com suporte a MySQL por padrão. Precisa instalar:
#        RUN docker-php-ext-install mysqli pdo_mysql
#      - mysqli: extensão que usamos neste projeto para falar com o MySQL
#      - pdo_mysql: alternativa (bom ter instalada)
#
#   3. HABILITAR MOD_REWRITE DO APACHE:
#      Necessário para o .htaccess funcionar (redirecionar URLs pro index.php):
#        RUN a2enmod rewrite
#
#   4. CONFIGURAR O APACHE PARA ACEITAR .HTACCESS:
#      Por padrão, o Apache ignora arquivos .htaccess.
#      Precisa criar uma config que diga "AllowOverride All" para o diretório
#      /var/www/html (onde ficam nossos arquivos PHP).
#
#   5. EXPOR A PORTA 80:
#      EXPOSE 80
#
# ▸ CONCEITOS QUE PRECISO ESTUDAR:
#   - Docker (o que é, containers vs máquinas virtuais)
#   - Dockerfile (FROM, RUN, EXPOSE, COPY, WORKDIR)
#   - Imagens Docker (o que são, Docker Hub, tags)
#   - Apache (servidor web, mod_rewrite, AllowOverride)
#   - Extensões PHP (o que são, como instalar no Docker)
#
# ▸ COMO TESTAR SE FUNCIONA?
#   Rodar: docker-compose build php
#   Se não der erro, a imagem foi construída com sucesso.
#   Depois: docker-compose up php
#   Acessar http://localhost/ — deve mostrar algo do index.php.
#
# ▸ DICA:
#   Se precisar instalar mais extensões PHP no futuro (ex: curl, json, zip),
#   é só adicionar mais um RUN docker-php-ext-install aqui.
# =============================================================================
