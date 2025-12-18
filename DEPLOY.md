# Tutorial de Deploy - Caju Awards

## 📋 Requisitos do Servidor

- Ubuntu 20.04+ / Debian 11+
- PHP 8.2+
- MySQL 8.0+ / PostgreSQL 14+
- Nginx ou Apache
- Node.js 18+
- Composer 2+
- Git

## 🚀 Primeira Instalação no Servidor

### 1. Preparar o servidor

```bash
# Atualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar PHP 8.2 e extensões
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring \
php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd php8.2-intl

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js 18
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Instalar Nginx
sudo apt install -y nginx

# Instalar MySQL
sudo apt install -y mysql-server
```

### 2. Configurar MySQL

```bash
sudo mysql_secure_installation

# Criar banco de dados
sudo mysql -u root -p
```

```sql
CREATE DATABASE caju_awards;
CREATE USER 'caju_user'@'localhost' IDENTIFIED BY 'senha_segura_aqui';
GRANT ALL PRIVILEGES ON caju_awards.* TO 'caju_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Clonar o projeto

```bash
# Ir para o diretório do servidor
cd /var/www

# Clonar repositório
sudo git clone https://github.com/seu-usuario/caju-awards.git
cd caju-awards

# Ajustar permissões
sudo chown -R www-data:www-data /var/www/caju-awards
sudo chmod -R 755 /var/www/caju-awards
```

### 4. Configurar o projeto

```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Editar configurações
nano .env
```

Configurar as seguintes variáveis no `.env`:

```env
APP_NAME="Caju Awards"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=caju_awards
DB_USERNAME=caju_user
DB_PASSWORD=senha_segura_aqui

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
```

### 5. Instalar e configurar

```bash
# Instalar dependências
composer install --no-dev --optimize-autoloader
npm ci

# Gerar chave da aplicação
php artisan key:generate

# Executar migrations
php artisan migrate --force

# Build dos assets
npm run build

# Criar link do storage
php artisan storage:link

# Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

### 6. Configurar Nginx

```bash
sudo nano /etc/nginx/sites-available/caju-awards
```

Adicionar:

```nginx
server {
    listen 80;
    server_name seu-dominio.com;
    root /var/www/caju-awards/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Ativar o site:

```bash
sudo ln -s /etc/nginx/sites-available/caju-awards /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 7. Configurar SSL (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d seu-dominio.com
```

### 8. Ajustar permissões finais

```bash
sudo chown -R www-data:www-data /var/www/caju-awards/storage
sudo chown -R www-data:www-data /var/www/caju-awards/bootstrap/cache
sudo chmod -R 755 /var/www/caju-awards/storage
sudo chmod -R 755 /var/www/caju-awards/bootstrap/cache
```

## 🔄 Deploy de Atualizações

Para deploys subsequentes, use o script automatizado:

```bash
# Dar permissão de execução (apenas primeira vez)
chmod +x deploy.sh

# Executar deploy
bash deploy.sh
```

### Deploy manual (sem script)

```bash
cd /var/www/caju-awards
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

## 🔧 Configurações Opcionais

### Queue Worker (Laravel Horizon ou Supervisor)

Se usar filas, configure o Supervisor:

```bash
sudo apt install -y supervisor
sudo nano /etc/supervisor/conf.d/caju-awards.conf
```

```ini
[program:caju-awards-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/caju-awards/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/caju-awards/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start caju-awards-worker:*
```

### Configurar Cron (Agendador)

```bash
sudo crontab -e -u www-data
```

Adicionar:

```
* * * * * cd /var/www/caju-awards && php artisan schedule:run >> /dev/null 2>&1
```

## 📊 Verificações Pós-Deploy

1. Acesse o site: `https://seu-dominio.com`
2. Verifique logs: `tail -f storage/logs/laravel.log`
3. Teste o painel admin: `https://seu-dominio.com/admin`
4. Verifique permissões: `ls -la storage/`

## 🐛 Troubleshooting

### Erro 500

```bash
php artisan cache:clear
php artisan config:clear
chmod -R 755 storage bootstrap/cache
```

### Assets não carregam

```bash
npm run build
php artisan filament:optimize
```

### Permissões

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 storage bootstrap/cache
```

## 📝 Checklist de Deploy

- [ ] Código atualizado (git pull)
- [ ] Dependências instaladas (composer + npm)
- [ ] Assets compilados (npm run build)
- [ ] Migrations executadas
- [ ] Storage link criado
- [ ] Caches otimizados
- [ ] Permissões corretas
- [ ] SSL configurado
- [ ] Backup do banco realizado
- [ ] Site testado e funcionando

## 🔒 Segurança

1. Sempre mantenha `APP_DEBUG=false` em produção
2. Use senhas fortes no `.env`
3. Configure firewall (ufw)
4. Mantenha SSL ativo
5. Faça backups regulares
6. Monitore logs de erro

## 📞 Suporte

Para problemas, verifique:
- `storage/logs/laravel.log` - Logs da aplicação
- `/var/log/nginx/error.log` - Logs do Nginx
- `php artisan about` - Info do sistema
