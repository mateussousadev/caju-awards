#!/bin/bash

# Script de Deploy - Caju Awards
# Execute com: bash deploy.sh

set -e  # Para o script se houver erro

echo "🚀 Iniciando deploy..."

# 1. Atualizar código do repositório
echo "📥 Atualizando código..."

eval "$(ssh-agent -s)"
git pull origin main

# 2. Instalar dependências do Composer
echo "📦 Instalando dependências do PHP..."
composer install --no-dev --optimize-autoloader

# 3. Instalar dependências do NPM
echo "📦 Instalando dependências do Node..."
npm ci --production=false

# 4. Build dos assets
echo "🏗️ Compilando assets..."
npm run build

# 5. Otimizar autoload
echo "⚡ Otimizando autoload..."
composer dump-autoload --optimize

# 6. Executar migrations
echo "🗄️ Executando migrations..."
php artisan migrate --force

# 7. Criar link do storage
echo "🔗 Criando link do storage..."
php artisan storage:link

# 8. Limpar e otimizar caches
echo "🧹 Limpando caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "⚡ Otimizando caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

# 9. Ajustar permissões
echo "🔐 Ajustando permissões..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

eval "$(ssh-agent -k)"

echo "✅ Deploy concluído com sucesso!"
echo "📊 Visite seu site para verificar"
