# Deployment Guide

This guide will help you deploy the Movie Booking System to a production server.

## Pre-deployment Checklist

### 1. Server Requirements
- [ ] PHP 7.4 or higher
- [ ] MySQL 5.7 or higher
- [ ] Apache/Nginx web server
- [ ] SSL certificate (recommended)
- [ ] Sufficient disk space (minimum 1GB)

### 2. Security Preparation
- [ ] Change database passwords
- [ ] Update admin credentials
- [ ] Enable HTTPS
- [ ] Configure file permissions
- [ ] Set up backup strategy

## Deployment Steps

### 1. File Upload
```bash
# Upload files to server
scp -r phpproj/ user@yourserver.com:/var/www/html/movie-booking/

# Or use FTP/SFTP client
```

### 2. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE mirai CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
GRANT ALL PRIVILEGES ON mirai.* TO 'movie_user'@'localhost' IDENTIFIED BY 'secure_password';
FLUSH PRIVILEGES;
EXIT;

# Import database
mysql -u movie_user -p mirai < mirai.sql
```

### 3. Configuration
```bash
# Copy environment file
cp .env.example .env

# Edit configuration
nano .env
```

Update `.env` with production values:
```
DB_HOST=localhost
DB_NAME=mirai
DB_USER=movie_user
DB_PASS=secure_password
APP_URL=https://yourdomain.com/movie-booking
DEBUG_MODE=false
```

### 4. File Permissions
```bash
# Set proper permissions
chmod 755 -R /var/www/html/movie-booking/
chmod 777 /var/www/html/movie-booking/uploads/
chmod 777 /var/www/html/movie-booking/logs/
chmod 777 /var/www/html/movie-booking/backups/

# Secure config files
chmod 600 /var/www/html/movie-booking/.env
chmod 600 /var/www/html/movie-booking/config.php
```

### 5. Web Server Configuration

#### Apache (.htaccess)
```apache
RewriteEngine On

# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
Header always set Content-Security-Policy "default-src 'self'"

# Hide sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

<Files "config.php">
    Order allow,deny
    Deny from all
</Files>

# Prevent access to logs and backups
RedirectMatch 404 ^/logs/.*$
RedirectMatch 404 ^/backups/.*$
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl;
    server_name yourdomain.com;
    root /var/www/html/movie-booking;
    index index.php;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;

    # Security headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    add_header Strict-Transport-Security "max-age=63072000; includeSubDomains; preload";

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Deny access to sensitive files
    location ~ /\.(env|htaccess) {
        deny all;
    }

    location ~ ^/(logs|backups)/ {
        deny all;
    }
}
```

### 6. SSL Certificate
```bash
# Using Let's Encrypt
certbot --apache -d yourdomain.com

# Or using Nginx
certbot --nginx -d yourdomain.com
```

### 7. Database Security
```sql
-- Remove test data
DELETE FROM users WHERE email LIKE '%test%';
DELETE FROM admins WHERE niganame = 'test';

-- Update admin password
UPDATE admins SET password = '$2y$10$new_secure_hash' WHERE niganame = 'admin';
```

## Post-deployment Tasks

### 1. Testing
- [ ] Test user registration
- [ ] Test login functionality
- [ ] Test booking process
- [ ] Test admin panel
- [ ] Verify email functionality
- [ ] Check error handling

### 2. Monitoring Setup
```bash
# Set up log rotation
nano /etc/logrotate.d/movie-booking

# Add monitoring script to crontab
crontab -e
# Add: 0 2 * * * /usr/bin/php /var/www/html/movie-booking/maintenance.php backup
# Add: 0 3 * * 0 /usr/bin/php /var/www/html/movie-booking/maintenance.php optimize
```

### 3. Backup Strategy
```bash
# Daily database backup
0 2 * * * /usr/bin/php /var/www/html/movie-booking/maintenance.php backup

# Weekly file backup
0 1 * * 0 tar -czf /backup/movie-booking-$(date +\%Y\%m\%d).tar.gz /var/www/html/movie-booking/
```

## Security Hardening

### 1. PHP Configuration
```ini
# In php.ini
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_only_cookies = 1
file_uploads = On
upload_max_filesize = 5M
max_file_uploads = 10
```

### 2. Database Security
```sql
-- Remove anonymous users
DELETE FROM mysql.user WHERE User='';

-- Remove test database
DROP DATABASE IF EXISTS test;

-- Update root password
ALTER USER 'root'@'localhost' IDENTIFIED BY 'very_secure_password';

-- Flush privileges
FLUSH PRIVILEGES;
```

### 3. Firewall Rules
```bash
# Basic UFW rules
ufw allow ssh
ufw allow http
ufw allow https
ufw allow mysql from localhost
ufw enable
```

## Performance Optimization

### 1. PHP OpCache
```ini
# In php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### 2. Database Optimization
```sql
-- Add indexes for better performance
CREATE INDEX idx_bookings_user ON bookings(uid);
CREATE INDEX idx_bookings_date ON bookings(DATE);
CREATE INDEX idx_users_email ON users(Email);
```

### 3. Caching
- Enable browser caching for static assets
- Consider implementing Redis for session storage
- Use CDN for static assets if needed

## Maintenance

### Daily Tasks
- Monitor error logs
- Check backup completion
- Review security logs

### Weekly Tasks
- Update system packages
- Optimize database tables
- Clean old log files

### Monthly Tasks
- Security audit
- Performance review
- Backup verification
- SSL certificate check

## Troubleshooting

### Common Issues

1. **Permission Denied**
   ```bash
   chown -R www-data:www-data /var/www/html/movie-booking/
   chmod -R 755 /var/www/html/movie-booking/
   ```

2. **Database Connection Failed**
   - Check MySQL service status
   - Verify database credentials
   - Check firewall rules

3. **File Upload Issues**
   ```bash
   chmod 777 /var/www/html/movie-booking/uploads/
   # Check PHP upload settings
   ```

4. **Session Problems**
   ```bash
   chmod 777 /tmp
   # Or check session.save_path in php.ini
   ```

## Support

For deployment issues:
- Check server error logs: `tail -f /var/log/apache2/error.log`
- Check application logs: `tail -f logs/error.log`
