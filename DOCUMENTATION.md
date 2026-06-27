# LGA Workforce Identity & Verification Management System
## Complete Installation & Documentation Guide

---

## Table of Contents

1. [System Overview](#system-overview)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Environment Setup](#environment-setup)
5. [Database Setup](#database-setup)
6. [Post-Installation](#post-installation)
7. [Default Login Credentials](#default-login-credentials)
8. [System Architecture](#system-architecture)
9. [Module Documentation](#module-documentation)
10. [API Documentation](#api-documentation)
11. [Deployment Guide](#deployment-guide)
12. [Security Guidelines](#security-guidelines)
13. [Backup & Restore](#backup--restore)
14. [Troubleshooting](#troubleshooting)
15. [FAQ](#faq)

---

## System Overview

The LGA Workforce Identity & Verification Management System is a production-ready, enterprise-grade web application for managing all government workers within a Local Government Authority (LGA).

### Key Features
- Worker Registration & Profile Management
- Multi-stage Verification Workflow
- Digital ID Card Generation (PDF)
- QR Code-based Staff Verification
- Public Verification Portal (no login required)
- Admin Panel (Filament v3)
- Worker Self-Service Portal
- Department & Office Management
- Audit Logging
- REST API for Mobile Apps

### Technology Stack
| Component | Technology |
|-----------|-----------|
| Backend Framework | Laravel 13 |
| PHP Version | 8.4+ |
| Database | MySQL 8 / MariaDB 10.11+ |
| Admin Panel | Filament v3.3 |
| Authentication | Laravel Auth + Sanctum |
| Permissions | Spatie Laravel Permission |
| Media Files | Spatie Media Library |
| Activity Logging | Spatie Activity Log |
| PDF Generation | barryvdh/laravel-dompdf |
| QR Codes | SimpleSoftwareIO/simple-qrcode |
| Image Processing | Intervention Image v3 |
| Frontend | Tailwind CSS + Alpine.js + Livewire |

---

## Requirements

### Server Requirements
- PHP 8.4 or higher
- MySQL 8.0+ or MariaDB 10.11+
- Composer 2.x
- Node.js 18+ (for asset compilation)
- Apache 2.4+ or Nginx 1.20+
- SSL Certificate (for production)

### PHP Extensions Required
- BCMath, Ctype, cURL, DOM
- Fileinfo, JSON, Mbstring
- OpenSSL, PCRE, PDO (MySQL)
- Tokenizer, XML, GD (for images)
- ZIP

---

## Installation

### Step 1: Clone / Upload Project
```bash
git clone [repository-url] /var/www/lgadb
cd /var/www/lgadb
```

### Step 2: Install PHP Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### Step 3: Set Directory Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Step 4: Create Environment File
```bash
cp .env.example .env
php artisan key:generate
```

---

## Environment Setup

Edit the `.env` file with your configuration:

```env
APP_NAME="LGA Workforce Identity System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.gov.ng

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lgadb
DB_USERNAME=lgadb_user
DB_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-email.com
MAIL_PORT=587
MAIL_USERNAME=noreply@your-domain.gov.ng
MAIL_PASSWORD=your_mail_password
MAIL_FROM_ADDRESS=noreply@your-domain.gov.ng
MAIL_FROM_NAME="LGA Workforce System"

QUEUE_CONNECTION=database
SESSION_DRIVER=database

LGA_NAME="Your LGA Name"
LGA_STATE="Your State"
LGA_CODE="LGA001"
LGA_PHONE="+2348012345678"
LGA_EMAIL="info@lgadb.gov.ng"
LGA_ADDRESS="LGA Secretariat, Your City"
```

---

## Database Setup

### Step 1: Create Database
```sql
CREATE DATABASE lgadb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'lgadb_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON lgadb.* TO 'lgadb_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

### Step 3: Seed Initial Data
```bash
php artisan db:seed
```

This creates:
- 4 demo user accounts
- 1 region, 1 state, 1 LGA, 6 wards
- 8 departments, 21 units, 4 offices
- 100 sample worker records
- Settings, FAQs, Pages, ID Card Template

### Step 4: Create Storage Link
```bash
php artisan storage:link
mkdir -p storage/app/public/id-cards
```

---

## Post-Installation

### Queue Worker Setup
For email notifications and background jobs:

```bash
# For development (test only)
php artisan queue:work

# For production (use supervisor)
# Install supervisor:
sudo apt-get install supervisor

# Create config: /etc/supervisor/conf.d/lgadb-worker.conf
[program:lgadb-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/lgadb/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/lgadb/storage/logs/worker.log

# Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start lgadb-worker:*
```

### Cron Job Setup
```bash
# Add to crontab (crontab -e as www-data)
* * * * * cd /var/www/lgadb && php artisan schedule:run >> /dev/null 2>&1
```

### Cache Setup (Production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Default Login Credentials

> ⚠️ **IMPORTANT**: Change all passwords immediately after first login!

| Role | Email | Password | Portal |
|------|-------|----------|--------|
| Super Administrator | admin@lgadb.gov.ng | Admin@12345 | /admin |
| HR Officer | hr@lgadb.gov.ng | Hr@12345 | /admin |
| Department Manager | manager@lgadb.gov.ng | Manager@12345 | /admin |
| Worker (Demo) | worker@lgadb.gov.ng | Worker@12345 | /portal/dashboard |

---

## System Architecture

### Directory Structure
```
lgadb/
├── app/
│   ├── Console/
│   │   └── Commands/          # Custom Artisan commands
│   ├── Enums/                 # PHP 8.1 Backed Enums
│   │   ├── WorkerStatus.php
│   │   ├── VerificationStatus.php
│   │   ├── EmploymentType.php
│   │   ├── DocumentType.php
│   │   ├── Gender.php
│   │   └── RoleType.php
│   ├── Filament/
│   │   ├── Pages/             # Custom Filament pages
│   │   ├── Resources/         # Filament CRUD resources
│   │   └── Widgets/           # Dashboard widgets
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Api/           # REST API controllers
│   │       ├── Auth/          # Authentication
│   │       ├── PublicController.php
│   │       ├── VerificationController.php
│   │       └── WorkerPortalController.php
│   ├── Models/                # Eloquent models
│   ├── Providers/             # Service providers
│   └── Services/              # Business logic services
│       └── IdCardService.php
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Data seeders
├── resources/
│   └── views/
│       ├── auth/              # Authentication pages
│       ├── filament/          # Filament customizations
│       ├── layouts/           # Master layouts
│       ├── pdf/               # PDF templates
│       ├── portal/            # Worker portal views
│       └── public/            # Public-facing views
└── routes/
    ├── api.php                # REST API routes
    ├── auth.php               # Authentication routes
    ├── console.php            # Console commands/scheduling
    └── web.php                # Web routes
```

### Key Models & Relationships
```
User ─────────── Worker (1:1)
               ├── Department (N:1)
               ├── Unit (N:1)
               ├── Office (N:1)
               ├── State (N:1)
               ├── Lga (N:1)
               ├── Ward (N:1)
               ├── EmploymentHistories (1:N)
               └── WorkerDocuments (1:N)

Department ──── Units (1:N)
             └── Workers (1:N)

Lga ──────────── Departments (1:N)
              ├── Offices (1:N)
              ├── Wards (1:N)
              └── Workers (1:N)
```

---

## Module Documentation

### 1. Worker Verification Workflow

```
Registration → Pending → Under Review → Approved → ID Card Generated
                ↓                         ↓
            Rejected ←─────────── Admin Review
```

**To verify a worker (Admin):**
1. Go to Admin Panel → Workers
2. Click on the worker record
3. Click "Verify" action button
4. Worker status changes to Active, verification_status to Approved
5. ID card can now be generated

### 2. Public Verification Portal

URL: `/verify`

Users can search by:
- Staff Number
- Email Address
- Phone Number  
- National ID
- Verification Code
- Surname
- Full Name

QR Code scanning: `/verify/qr/{hash}` — direct link from ID card QR

### 3. ID Card Generation

ID cards are generated as PDFs with:
- **Front**: Photo, Name, Staff Number, Department, Designation, QR Code, Expiry Date
- **Back**: Emergency Contact, Verification URL, Office Info

To generate via admin:
1. Admin Panel → Workers → [Worker] → "Generate ID Card" action

To generate via CLI:
```bash
# Generate for all pending
php artisan workers:generate-id-cards

# Generate for specific worker
php artisan workers:generate-id-cards --worker=1
```

### 4. Departments & Organization

Hierarchy: LGA → Department → Unit → Worker

- Create departments at: Admin → Departments → Create
- Create units at: Admin → Units → Create
- Assign workers during registration or via edit

### 5. Settings Module

Access: Admin Panel → Settings

Key settings:
- `org_name` — Organization name
- `org_phone` — Office phone
- `id_card_expiry_years` — ID card validity period

---

## API Documentation

Base URL: `/api/v1`

### Authentication

**Login**
```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "user@lgadb.gov.ng",
    "password": "password"
}
```

Response:
```json
{
    "token": "1|abc123...",
    "user": { "id": 1, "name": "...", "role_type": "worker" }
}
```

**Authenticated Requests**
```http
Authorization: Bearer {token}
```

### Worker Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/v1/worker/profile | Get own profile |
| PUT | /api/v1/worker/profile | Update allowed fields |
| GET | /api/v1/worker/documents | List documents |
| GET | /api/v1/worker/history | Employment history |
| GET | /api/v1/worker/id-card | ID card download link |

### Public Verification Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/v1/verify/{code} | Verify by code |
| GET | /api/v1/verify/qr/{hash} | Verify by QR hash |
| POST | /api/v1/verify/search | Search verified staff |

---

## Deployment Guide

### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName lgadb.gov.ng
    DocumentRoot /var/www/lgadb/public

    <Directory /var/www/lgadb/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/lgadb-error.log
    CustomLog ${APACHE_LOG_DIR}/lgadb-access.log combined
</VirtualHost>
```

Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name lgadb.gov.ng;
    root /var/www/lgadb/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### SSL Setup (Let's Encrypt)
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d lgadb.gov.ng
```

### Production Checklist
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure proper database credentials
- [ ] Set up SSL certificate
- [ ] Configure SMTP mail settings
- [ ] Run `php artisan optimize`
- [ ] Set up queue worker with Supervisor
- [ ] Configure cron job for scheduler
- [ ] Change all default passwords
- [ ] Configure proper file permissions
- [ ] Enable OPcache in PHP
- [ ] Set up regular database backups
- [ ] Test all email notifications
- [ ] Test QR code verification
- [ ] Test ID card PDF generation

---

## Security Guidelines

1. **Passwords**: All user passwords are bcrypt hashed (cost factor 12)
2. **CSRF**: All forms protected with CSRF tokens
3. **XSS**: Blade templates auto-escape output; use `{!! !!}` only for trusted HTML
4. **SQL Injection**: All queries use Eloquent ORM or parameter binding
5. **File Uploads**: Validated by MIME type and stored in private storage
6. **Rate Limiting**: Login endpoint rate-limited
7. **Session**: Encrypted session driver
8. **Public Data**: Only verified workers with approved status shown publicly; no sensitive info (BVN, NIN details) exposed
9. **API**: Sanctum token authentication for API endpoints
10. **Permissions**: Role-based access control via Spatie Permission

---

## Backup & Restore

### Database Backup
```bash
# Manual backup
mysqldump -u root -p lgadb > /backups/lgadb_$(date +%Y%m%d).sql

# Compressed backup
mysqldump -u root -p lgadb | gzip > /backups/lgadb_$(date +%Y%m%d).sql.gz
```

### Restore
```bash
mysql -u root -p lgadb < /backups/lgadb_20250101.sql
```

### Files Backup
```bash
tar -czf /backups/lgadb_files_$(date +%Y%m%d).tar.gz /var/www/lgadb/storage/app
```

---

## Troubleshooting

### Common Issues

**1. 500 Error on Homepage**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
tail -f storage/logs/laravel.log
```

**2. Images/Files Not Loading**
```bash
php artisan storage:link
chmod -R 775 storage/
```

**3. Emails Not Sending**
```bash
php artisan queue:work
# Check .env MAIL_* settings
php artisan tinker
Mail::raw('test', fn($m) => $m->to('test@example.com')->subject('Test'));
```

**4. Migration Errors**
```bash
php artisan migrate:status
php artisan migrate:fresh --seed  # WARNING: Drops all data!
```

**5. Permission Denied Errors**
```bash
sudo chown -R www-data:www-data /var/www/lgadb
sudo chmod -R 755 /var/www/lgadb
sudo chmod -R 775 storage bootstrap/cache
```

**6. QR Code Not Working**
- Check `APP_URL` is correct in `.env`
- Ensure public URL is accessible
- Check GD/Imagick PHP extension is installed

---

## FAQ

**Q: How do I reset a worker's password?**  
A: Go to Admin → Users → Edit User → set new password. Or the user can use "Forgot Password".

**Q: Can a worker update their own information?**  
A: Yes, workers can update: phone, WhatsApp, residential address, next of kin details via their portal profile page.

**Q: How long is an ID card valid?**  
A: Default is 2 years, configurable via the `id_card_expiry_years` setting.

**Q: Can I add more departments?**  
A: Yes, Admin → Departments → Create Department.

**Q: How does QR verification work?**  
A: Each verified worker has a unique `verification_hash`. When the QR code on their ID is scanned, it opens `/verify/qr/{hash}` which shows their verified details.

**Q: How do I export worker data?**  
A: Admin Panel → Workers → table has export functionality. For bulk export, use the filter and export buttons.

**Q: Can this scale to multiple LGAs?**  
A: Yes! The database has `regions`, `states`, `lgas` tables. The architecture supports multi-LGA expansion. Set `lga_id` per worker to distinguish.

---

## Support

For technical support, contact the system administrator or raise an issue with the development team.

**System Version**: 1.0.0  
**Laravel Version**: 13.x  
**Filament Version**: 3.3.x  

