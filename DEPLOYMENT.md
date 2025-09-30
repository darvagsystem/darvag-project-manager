# Darvag Project Manager - Deployment Guide

## Prerequisites

### Server Requirements
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Node.js 18+ and NPM
- Nginx or Apache
- SSL Certificate (recommended)

### PHP Extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML
- Zip

## Deployment Steps

### 1. Server Setup

#### Install PHP 8.2 and required extensions:
```bash
sudo apt update
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd
```

#### Install Composer:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Install Node.js and NPM:
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Database Setup

Create a MySQL database:
```sql
CREATE DATABASE darvag_project_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'darvag_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON darvag_project_manager.* TO 'darvag_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Application Deployment

#### Clone the repository:
```bash
cd /var/www
sudo git clone https://github.com/yourusername/darvag-project-manager.git
sudo chown -R www-data:www-data darvag-project-manager
cd darvag-project-manager
```

#### Run the deployment script:
```bash
chmod +x deploy.sh
./deploy.sh
```

#### Or deploy manually:

1. **Install dependencies:**
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

2. **Configure environment:**
```bash
cp env.production.example .env
nano .env  # Edit with your production settings
```

3. **Generate application key:**
```bash
php artisan key:generate
```

4. **Run migrations:**
```bash
php artisan migrate --force
```

5. **Cache configurations:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. **Set permissions:**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 4. Web Server Configuration

#### Nginx Configuration:
```nginx
server {
    listen 80;
    listen 443 ssl;
    server_name yourdomain.com;
    root /var/www/darvag-project-manager/public;

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
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache Configuration (.htaccess in public folder):
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 5. SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

### 6. Queue Worker Setup

For background jobs, set up a queue worker:

```bash
sudo nano /etc/systemd/system/darvag-queue.service
```

Add the following content:
```ini
[Unit]
Description=Darvag Project Manager Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/darvag-project-manager/artisan queue:work --sleep=3 --tries=3 --max-time=3600
WorkingDirectory=/var/www/darvag-project-manager

[Install]
WantedBy=multi-user.target
```

Enable and start the service:
```bash
sudo systemctl enable darvag-queue.service
sudo systemctl start darvag-queue.service
```

### 7. Cron Jobs

Add Laravel scheduler to crontab:
```bash
sudo crontab -e
```

Add this line:
```
* * * * * cd /var/www/darvag-project-manager && php artisan schedule:run >> /dev/null 2>&1
```

### 8. Backup Setup

Create a backup script:
```bash
sudo nano /usr/local/bin/darvag-backup.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/darvag"
DB_NAME="darvag_project_manager"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u darvag_user -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/database_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/darvag-project-manager

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

Make it executable and add to crontab:
```bash
sudo chmod +x /usr/local/bin/darvag-backup.sh
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/darvag-backup.sh
```

## Environment Variables

Copy `env.production.example` to `.env` and configure:

- `APP_URL`: Your domain URL
- `DB_*`: Database connection settings
- `MAIL_*`: Email configuration
- `APP_DEBUG`: Set to `false` for production

## Post-Deployment

1. **Test the application** by visiting your domain
2. **Check logs** in `storage/logs/laravel.log`
3. **Monitor performance** and server resources
4. **Set up monitoring** (optional)

## Troubleshooting

### Common Issues:

1. **Permission errors**: Ensure `www-data` owns the storage and cache directories
2. **500 errors**: Check Laravel logs and PHP error logs
3. **Database connection**: Verify database credentials and connection
4. **Asset loading**: Ensure `npm run build` was executed

### Useful Commands:

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check queue status
php artisan queue:work --once

# Check scheduled tasks
php artisan schedule:list
```

## Security Considerations

1. **Keep dependencies updated**
2. **Use strong database passwords**
3. **Enable SSL/HTTPS**
4. **Regular backups**
5. **Monitor logs for suspicious activity**
6. **Keep server OS updated**

## Performance Optimization

1. **Enable OPcache** in PHP
2. **Use Redis** for caching (optional)
3. **Optimize database queries**
4. **Use CDN** for static assets (optional)
5. **Enable Gzip compression**

---

For support, contact the development team or check the project documentation.
