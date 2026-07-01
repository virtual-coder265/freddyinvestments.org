# 🚀 Complete Deployment Guide
## Freddy Investments CMS - Local & Production Setup

**Last Updated**: May 2026  
**Version**: 1.0  

---

## 📋 Table of Contents

1. [Quick Start Summary](#quick-start-summary)
2. [Local Deployment (XAMPP)](#local-deployment-xampp)
3. [Production Deployment (Shared Hosting)](#production-deployment-shared-hosting)
4. [Database Management](#database-management)
5. [Security Hardening](#security-hardening)
6. [Performance Optimization](#performance-optimization)
7. [Troubleshooting](#troubleshooting)
8. [Migration Guide](#migration-guide)
9. [Maintenance & Monitoring](#maintenance--monitoring)

---

## Quick Start Summary

### Local (XAMPP) - 3 Steps
1. Place files in `htdocs/freddyinvestments.org/`
2. Run setup-database.php via browser
3. Use your assigned credentials to login

### Production (Shared Hosting) - 5 Steps
1. Upload files via FTP/SFTP
2. Set directory permissions
3. Configure web server
4. Run setup-database.php via browser
5. Change default credentials

---

# Local Deployment (XAMPP)

## 1. System Requirements

```
✅ XAMPP 8.0+ (includes PHP 8.0+, Apache, SQLite3)
✅ 500 MB free disk space
✅ 4GB+ RAM recommended
✅ Windows, macOS, or Linux
✅ Browser (Chrome, Firefox, Safari, Edge)
```

## 2. Installation Steps

### Step 1: Download & Install XAMPP
1. Download from https://www.apachefriends.org
2. Run installer and select components:
   - Apache
   - PHP
   - SQLite (included)
3. Install to default location (e.g., `C:\xampp` on Windows)

### Step 2: Start XAMPP Services
- **Windows**: Open XAMPP Control Panel, start Apache
- **Mac/Linux**: Run `sudo /Applications/XAMPP/xamppfiles/xampp start` or equivalent

Verify: Navigate to `http://localhost` - you should see XAMPP dashboard

### Step 3: Project Setup

```bash
# Navigate to htdocs
cd C:\xampp\htdocs  # Windows
# or
cd /opt/lampp/htdocs  # Linux
# or
cd /Applications/XAMPP/htdocs  # macOS

# Clone or place project files
# Your project should be in: htdocs/freddyinvestments.org/
```

### Step 4: Directory Structure Verification

Ensure these directories exist and are writable:

```bash
cd b:\xampp\htdocs\freddyinvestments.org

# Create if missing
mkdir storage
mkdir storage\logs
mkdir public\uploads

# Windows: Set write permissions (usually automatic in XAMPP)
# Linux/Mac: Set permissions
chmod 755 storage
chmod 755 storage/logs
chmod 755 public/uploads
```

### Step 5: Initialize Database

**Option A: Browser (Easiest)**
1. Open browser → `http://localhost/freddyinvestments.org/setup-database.php`
2. Click "Initialize Database"
3. See success message with admin credentials
4. Database created: `storage/cms.db`

**Option B: Command Line**
```bash
cd b:\xampp\htdocs\freddyinvestments.org
php setup-database.php
```

### Step 6: First Login

1. Navigate to: `http://localhost/freddyinvestments.org/admin/login`
2. Enter credentials:
   - **Username**: `admin`
   - **Password**: (Use your assigned password)
3. Click "Login"

### Step 7: Security - Change Default Password

1. Logged in → Click on "Settings" in admin menu
2. Locate "Admin Password" section
3. Enter new password (min 8 chars, mix of upper/lower/numbers/symbols)
4. Click "Update Password"
5. Re-login with new credentials

### Step 8: Verify Installation

Check all sections are working:
- [ ] Dashboard loads (shows statistics)
- [ ] Pages section accessible
- [ ] Can create new page
- [ ] Can upload image to Assets
- [ ] Settings accessible
- [ ] Can view messages (if contact form active)

### Step 9: (Optional) Delete Setup File

After successful setup:
```bash
# Windows
del setup-database.php

# Linux/Mac
rm setup-database.php
```

## 3. Local Development URLs

```
Frontend Home:      http://localhost/freddyinvestments.org/
Frontend About:     http://localhost/freddyinvestments.org/about
Frontend Services:  http://localhost/freddyinvestments.org/services
Frontend Contact:   http://localhost/freddyinvestments.org/contact

⚠️ **Admin Access Note**: By default, admin access is DISABLED on production (`ADMIN_DISABLED_IN_PRODUCTION=true` in .env). To enable it, update your .env file and set it to `false`.

Development URLs:
- Admin Login:       http://localhost/freddyinvestments.org/admin/login
- Admin Dashboard:   http://localhost/freddyinvestments.org/admin/dashboard (after login)
```

## 4. Local Development - Database File Location

```
Windows:  C:\xampp\htdocs\freddyinvestments.org\storage\cms.db
Linux:    /opt/lampp/htdocs/freddyinvestments.org/storage/cms.db
macOS:    /Applications/XAMPP/htdocs/freddyinvestments.org/storage/cms.db
```

**Backup your database regularly:**
```bash
# Backup (create copy with timestamp)
copy storage\cms.db storage\cms_backup_2026-05-27.db
```

---

# Production Deployment (Shared Hosting)

## 1. System Requirements

```
✅ PHP 7.4+ (most hosts provide 8.0+)
✅ SQLite3 support enabled (verify with host)
✅ SSH/SFTP access
✅ 500 MB+ disk space
✅ SSL/HTTPS support (required)
✅ cPanel or similar control panel (optional but helpful)
```

**Verify your hosting has SQLite3 enabled:**
Contact your host or create a test file:
```php
<?php phpinfo(); ?>
```
Look for "sqlite3" section - must be present.

## 2. Pre-Deployment Checklist

Before uploading, prepare locally:

```bash
# In your local project directory, verify:
☑ All PHP files syntax correct (no parse errors)
☑ Database backup created
☑ setup-database.php still present (you'll need it)
☑ .htaccess file exists (for rewrites)
☑ All dependencies installed
☑ Default admin password changed locally (if testing)
```

## 3. File Upload to Shared Hosting

### Option A: FTP/SFTP Upload (Most Common)

1. **Connect to your host via FTP client** (FileZilla, WinSCP, etc.)
   ```
   Host: your-domain.com (or ftp.your-domain.com)
   Username: FTP username from host
   Password: FTP password
   Port: 21 (FTP) or 22 (SFTP)
   Protocol: SFTP recommended
   ```

2. **Navigate to public_html or www directory**
   ```
   Typical paths:
   - public_html/
   - www/
   - htdocs/
   - your-domain.com/ (for addon domains)
   ```

3. **Create project directory**
   ```
   Create new folder: freddyinvestments.org
   OR use existing folder if available
   ```

4. **Upload all project files**
   - Upload entire project folder contents
   - Verify all subdirectories transferred
   - Check that hidden files uploaded (.htaccess if exists)

5. **Verify file permissions** (critical)
   ```
   Via FTP client (right-click → Properties):
   - storage/ → 755 (or 777 if 755 doesn't work)
   - storage/logs/ → 755
   - public/uploads/ → 755
   - All other directories → 755
   - PHP files → 644
   - Database file → 666 (after creation)
   ```

### Option B: Git Deployment (Advanced)

If your host supports Git:
```bash
# On server via SSH
cd ~/public_html/freddyinvestments.org
git clone https://your-repo-url.git .
```

### Option C: SSH Upload

```bash
# From your local machine
scp -r ./freddyinvestments.org user@your-domain.com:~/public_html/
```

## 4. Web Server Configuration

### For Apache (Most Common)

Ensure `.htaccess` exists in project root with:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /freddyinvestments.org/
    
    # Route all requests to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

**Verify via cPanel:**
1. Log into cPanel
2. Go to "File Manager"
3. Navigate to your project root
4. Right-click `.htaccess` → "Edit"
5. Verify rewrite rules present
6. If missing, create new file with above content

### For Nginx (Advanced)

If your host uses Nginx, add to nginx config:
```nginx
location /freddyinvestments.org/ {
    # Route all requests to index.php
    try_files $uri $uri/ /index.php?url=$uri&$args;
}
```

Contact your host for Nginx configuration help.

## 5. Production Database Setup

### Step 1: Create Directory (if using file-based SQLite)

Via SSH or cPanel File Manager:
```bash
# Via SSH
mkdir -p ~/public_html/freddyinvestments.org/storage
chmod 755 ~/public_html/freddyinvestments.org/storage

mkdir -p ~/public_html/freddyinvestments.org/public/uploads
chmod 755 ~/public_html/freddyinvestments.org/public/uploads
```

### Step 2: Initialize Database

**Via Browser (Easiest)**
1. Open: `https://your-domain.com/freddyinvestments.org/setup-database.php`
2. Click "Initialize Database"
3. Wait for completion (may take 30-60 seconds on slow hosts)
4. Note the default credentials shown
5. Database file created at: `storage/cms.db`

**Verify database created:**
- Via FTP, navigate to `storage/cms.db` - file should exist
- File size should be > 100 KB

### Step 3: Set Database Permissions

Via SSH or cPanel File Manager:
```bash
chmod 666 ~/public_html/freddyinvestments.org/storage/cms.db
```

Or via FTP (right-click file → Properties): Set to `666`

## 6. Production Security Hardening

### Step 1: Change Default Admin Credentials

1. Navigate to: `https://your-domain.com/freddyinvestments.org/admin/login`
2. Login with your assigned credentials
3. Go to Settings → Admin Password
4. Change to strong password (min 12 chars with mixed case, numbers, symbols)
5. **Save new credentials in password manager**

### Step 2: Delete Setup File

Via SSH or FTP delete:
```bash
rm setup-database.php
# Or via FTP: right-click → Delete
```

This prevents unauthorized database reinitializations.

### Step 3: Enable HTTPS/SSL

1. In cPanel → SSL/TLS Status
2. Install free SSL certificate (AutoSSL)
3. Force HTTPS redirect:

Create/update `.htaccess`:
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Step 4: Configure Security Headers

Add to `.htaccess` or via cPanel:
```apache
# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
Header set Strict-Transport-Security "max-age=31536000; includeSubDomains"
```

### Step 5: Protect Sensitive Directories

Add to `.htaccess`:
```apache
# Protect storage directory
<FilesMatch "\.db$">
    Deny from all
</FilesMatch>

# Protect admin panel access (optional - add your IP)
<Files "admin/login.php">
    Allow from all
</Files>
```

### Step 6: Enable Error Logging

In project root create `.htaccess`:
```apache
# Log errors but don't display them
php_flag display_errors off
php_flag log_errors on
php_value error_log ~/public_html/freddyinvestments.org/storage/logs/php_errors.log
```

## 7. Production DNS & Domain Setup

### Point Domain to Hosting

1. Access domain registrar (GoDaddy, Namecheap, etc.)
2. Update nameservers to your hosting provider's
   - Your host provides these (check welcome email)
   - Usually 2 nameserver addresses
3. Save changes (may take 24 hours to propagate)

### Configure Hosting

1. In cPanel → "Addon Domains" or "Domains"
2. Add your domain: `freddyinvestments.org`
3. Document root: `public_html/freddyinvestments.org`
4. Install SSL certificate

### Verify Setup

After DNS propagates:
```bash
# Test DNS resolution
nslookup freddyinvestments.org
ping freddyinvestments.org

# Should resolve to your hosting IP
```

## 8. Production Environment Verification

Test everything works:

**URLs to test:**
```
Frontend:  https://freddyinvestments.org/
⚠️ **IMPORTANT - Production Security**: Admin access is DISABLED by default in production. To enable:
1. Update `.env` file and set `ADMIN_DISABLED_IN_PRODUCTION=false`
2. Login at: https://freddyinvestments.org/admin/login
3. Change your admin credentials immediately
```

**Functionality checklist:**
- [ ] Frontend pages load
- [ ] Admin login works
- [ ] Dashboard shows statistics
- [ ] Can create/edit pages
- [ ] Can upload images
- [ ] Contact form works (if enabled)
- [ ] HTTPS connection established
- [ ] No SSL warnings

---

# Database Management

## Database Structure

```
Location: storage/cms.db
Type: SQLite3
Size: ~500 KB average
Backup: Regular backups recommended
```

### Tables Overview

| Table | Purpose | Rows |
|-------|---------|------|
| admins | Admin users | 1-10 |
| pages | Website pages | 5-100 |
| services | Company services | 5-20 |
| tips | Articles/tips | 10-100+ |
| quotes | Testimonials | 10-50 |
| messages | Contact messages | 0-1000+ |
| assets | Media files | 5-500+ |
| business_settings | Configuration | 20-30 |
| audit_logs | Activity logs | 100-10000+ |

## Backup & Restore

### Local Backup (XAMPP)

```bash
# Manual backup
copy storage\cms.db storage\cms_backup_2026-05-27.db

# Or schedule daily via Task Scheduler (Windows)
```

### Production Backup (Shared Hosting)

**Via FTP:**
1. Connect via FTP client
2. Navigate to `storage/cms.db`
3. Right-click → "Download"
4. Save to local machine
5. Label with date

**Via cPanel:**
1. In cPanel → Backups
2. Select "Backup Now"
3. Choose Home Directory backup
4. Download to local machine

**Automated Backup Script:**
Create `backup.php` and schedule via cron:
```php
<?php
$file = 'storage/cms.db';
$backup_file = 'storage/backups/cms_' . date('Y-m-d_H-i-s') . '.db';
copy($file, $backup_file);
echo "Backup created: " . $backup_file;
?>
```

Schedule via cPanel → Cron Jobs (daily at 2 AM):
```
0 2 * * * /usr/bin/php /home/user/public_html/freddyinvestments.org/backup.php
```

### Restore from Backup

**If database corrupted:**

1. Delete current database: `storage/cms.db`
2. Upload backup file as `cms.db`
3. Set permissions: `chmod 666 storage/cms.db`
4. Test login - should work with backed-up data

## Database Maintenance

### Local Cleanup (XAMPP)

```bash
# Via SQLite client
sqlite3 storage/cms.db

# Run maintenance commands
PRAGMA optimize;
VACUUM;

# Exit
.quit
```

### Production Cleanup (Shared Hosting)

Via cPanel → phpMyAdmin (if available) or SSH:
```bash
# SSH connection
ssh user@your-domain.com

cd ~/public_html/freddyinvestments.org
sqlite3 storage/cms.db "PRAGMA optimize; VACUUM;"
```

---

# Security Hardening

## 1. Authentication Security

### Strong Passwords

```
✅ Minimum 12 characters
✅ Mix of uppercase, lowercase, numbers, symbols
✅ No dictionary words
✅ Unique passwords for each admin

Example: Pr0d#S3cur3P@ss2026!
```

### Session Security

```php
// Configured in src/Auth/AuthManager.php
- Session timeout: 30 minutes
- Secure cookies (HTTPS only in production)
- HttpOnly flag set
- CSRF tokens on all forms
```

### Prevent Brute Force

Rate limit login attempts:
```php
// Add to AdminAuthController.php (optional)
if ($failed_attempts > 5) {
    $_SESSION['login_locked_until'] = time() + 900; // 15 min lock
}
```

## 2. Input Validation

All user inputs validated:
```
✅ Type checking (string, integer, email)
✅ Length validation (max 255 chars for titles)
✅ Safe HTML allowed (Tinymce in production)
✅ File upload validation (jpg, png, gif, max 5MB)
```

## 3. SQL Injection Prevention

All database queries use prepared statements:
```php
// Safe: Uses parameterized queries
$stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

// Vulnerable: Direct string interpolation (DO NOT USE)
$query = "SELECT * FROM users WHERE username = '$username'";
```

## 4. XSS Prevention

Output encoding:
```php
// Safe: HTML encoded
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// Vulnerable: Direct output (DO NOT USE)
echo $user_input;
```

## 5. CSRF Protection

CSRF tokens on all forms:
```html
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
```

Verify in controllers:
```php
if ($this->request->post('csrf_token') !== $_SESSION['csrf_token']) {
    die('CSRF token mismatch');
}
```

## 6. File Upload Security

```php
// Allowed extensions only
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    die('Invalid file type');
}

// Size limit: 5MB
if ($_FILES['file']['size'] > 5 * 1024 * 1024) {
    die('File too large');
}

// Rename to random filename
$new_name = uniqid() . '.' . $ext;
move_uploaded_file($tmp_name, 'public/uploads/' . $new_name);
```

## 7. Production Security Checklist

```
☑ SSL/HTTPS enabled and forced
☑ setup-database.php deleted
☑ Default admin password changed
☑ File permissions set correctly (755/644)
☑ Database file not accessible via web (666 ok)
☑ Error messages not exposed (display_errors off)
☑ Logs stored outside web root
☑ Backups automated and tested
☑ Security headers configured
☑ Admin panel protected (IP whitelist optional)
☑ Database backups encrypted
☑ Audit logs reviewed weekly
☑ Two-factor authentication considered (future)
☑ Regular security updates for PHP/server
```

---

# Performance Optimization

## 1. PHP Configuration

### Local (XAMPP)

Edit `php.ini` in XAMPP folder:

```ini
; Increase limits for development
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M

; Enable caching (development)
opcache.enable = 1
opcache.memory_consumption = 128
```

### Production (Shared Hosting)

Ask your host or via cPanel → PHP Configuration:

```ini
; Conservative settings (shared hosting)
memory_limit = 128M
max_execution_time = 60
upload_max_filesize = 5M

; Enable opcache for performance
opcache.enable = 1
opcache.memory_consumption = 64
```

## 2. Database Optimization

```bash
# Run optimization
sqlite3 storage/cms.db "PRAGMA optimize;"

# Analyze query performance
PRAGMA explain_query_plan;
```

Add indexes (if needed for large databases):
```sql
CREATE INDEX idx_pages_status ON pages(status);
CREATE INDEX idx_messages_read ON messages(is_read);
CREATE INDEX idx_audit_logs_date ON audit_logs(created_at);
```

## 3. Caching

Enable query result caching:
```php
// In Models/Model.php
private static $cache = [];

public static function cache_get($key) {
    return self::$cache[$key] ?? null;
}

public static function cache_set($key, $value) {
    self::$cache[$key] = $value;
}
```

## 4. Frontend Performance

### CSS/JS Optimization

```html
<!-- Minify in production -->
<link rel="stylesheet" href="assets/css/style.min.css">
<script src="assets/js/main.min.js" defer></script>

<!-- Lazy load images -->
<img src="image.jpg" loading="lazy" alt="Description">
```

### Enable Compression

Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

## 5. Monitoring Performance

```bash
# Check database size
du -h storage/cms.db

# Check audit logs growth
SELECT COUNT(*) FROM audit_logs;

# Archive old logs if needed
DELETE FROM audit_logs WHERE created_at < DATE('now', '-30 days');
```

---

# Troubleshooting

## Local Issues (XAMPP)

### "Page not found" (404 error)

**Cause**: URL routing not working

**Solution**:
1. Check `.htaccess` exists in project root
2. Verify Apache mod_rewrite enabled:
   - XAMPP Control Panel → Apache → Config → httpd.conf
   - Search for "LoadModule rewrite_module"
   - If commented (#), uncomment and restart Apache

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

### Database won't initialize

**Cause**: Directory permissions or missing folder

**Solution**:
```bash
# Create directories
mkdir storage
mkdir storage/logs
mkdir public/uploads

# Windows: Usually automatic, but verify write permission
# Linux/Mac: Set permissions
chmod 755 storage
chmod 755 public/uploads
```

### "PDO Exception: Could not find driver"

**Cause**: SQLite3 PHP extension not loaded

**Solution**:
1. XAMPP Control Panel → Apache → Config → php.ini
2. Find: `;extension=pdo_sqlite`
3. Remove the semicolon: `extension=pdo_sqlite`
4. Save and restart Apache

### Login not working

**Cause**: Session not starting or database empty

**Solution**:
1. Verify database initialized: check `storage/cms.db` exists (> 100 KB)
2. If not, run `setup-database.php` again
3. Clear browser cookies/cache
4. Try incognito/private browsing window

### File upload fails

**Cause**: Directory permissions or size limit

**Solution**:
```bash
# Check permissions
chmod 755 public/uploads

# Check PHP limit in php.ini
upload_max_filesize = 10M
post_max_size = 10M

# Check file size < 5MB
```

## Production Issues (Shared Hosting)

### "Internal Server Error" (500)

**Cause**: Multiple possibilities (PHP error, permission, config)

**Solution**:
1. Check error logs: cPanel → Logs → Error Log
2. Verify file permissions: all 755, db 666
3. Check `.htaccess` syntax (comment out temporarily to test)
4. Contact host if PHP version issue

### Database not creating

**Cause**: Permission denied or directory missing

**Solution**:
1. Create `storage/` via FTP/cPanel File Manager
2. Set permissions to 755
3. Run `setup-database.php` again
4. After creation, set `cms.db` to 666

### "Permission Denied" errors

**Solution**:
```
Via FTP (right-click → Properties):
- storage/ → 755
- public/uploads/ → 755
- storage/cms.db → 666 (after creation)
- All .php files → 644
```

### Slow page load

**Cause**: Server load, database size, or inefficient code

**Solutions**:
1. Archive old audit logs: `DELETE FROM audit_logs WHERE created_at < DATE('now', '-90 days');`
2. Optimize database: `PRAGMA optimize;`
3. Check PHP memory limit, increase if needed
4. Enable caching (see Performance section)
5. Contact host about server resources

### HTTPS not working

**Cause**: SSL not installed or redirect issue

**Solution**:
1. In cPanel → SSL/TLS Status → Install Auto SSL
2. Add redirect to `.htaccess`:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Can't login after moving to production

**Cause**: Database didn't transfer or corrupted

**Solution**:
1. Delete `storage/cms.db` on server
2. Run `setup-database.php` again
3. Use your assigned credentials
4. Change password immediately

---

# Migration Guide

## Moving from Local to Production

### Step 1: Local Preparation

```bash
# Backup local database
copy storage\cms.db storage\cms_local_backup.db

# Export local content (optional - before migration)
# Create a backup of everything you've created
```

### Step 2: Upload Project Files

See "File Upload to Shared Hosting" section above.

### Step 3: Fresh Database Setup

**Recommended**: Initialize fresh on production
1. Run `setup-database.php` on production
2. Create content again on production
3. This ensures optimal database

**Alternative**: Migrate local database
1. Download `storage/cms.db` from local
2. Upload to `storage/cms.db` on production
3. Set permissions to 666
4. Should work as-is with all local content

### Step 4: Update Admin Credentials

1. Login to production admin
2. Change password from default
3. Update any business settings for production

### Step 5: Verify Migration

```
☑ Admin login works
☑ All content appears
☑ File uploads work
☑ Contact form works (if using local database)
☑ HTTPS loads properly
☑ Email notifications work (if configured)
```

### Step 6: Rollback Plan (if needed)

If production has issues:
1. Keep local copy as backup
2. Delete production database
3. Re-run setup or upload backup
4. Investigate issue before trying again

---

# Maintenance & Monitoring

## Regular Maintenance Tasks

### Weekly
```
☑ Review admin dashboard (check for errors)
☑ Check contact messages (if contact form active)
☑ Review audit logs for suspicious activity
☑ Verify backups completed successfully
```

### Monthly
```
☑ Update admin password (if shared)
☑ Archive old audit logs (> 90 days)
☑ Optimize database: PRAGMA optimize;
☑ Check server disk space available
☑ Review error logs for recurring issues
```

### Quarterly
```
☑ Full database backup and verify restoration
☑ Security audit (check permissions, SSL, etc.)
☑ Review PHP version and security updates
☑ Test disaster recovery procedure
☑ Update documentation
```

### Annually
```
☑ Renew SSL certificate (if not auto-renewed)
☑ Review all admin users and credentials
☑ Audit all data for accuracy
☑ Plan for feature upgrades
☑ Review performance metrics
```

## Monitoring Checklist

### Performance Monitoring

```bash
# Check database size
du -h storage/cms.db

# Check server disk space (production)
df -h

# Monitor access via server logs
tail -f /var/log/apache2/access.log

# Check error logs
tail -f /var/log/apache2/error.log
```

### Security Monitoring

```
☑ Login attempts (successful & failed) in audit_logs
☑ File modifications (check timestamps)
☑ Unusual database activity
☑ SSL certificate expiration date
☑ File permission changes
```

### Database Monitoring

```bash
# Check table sizes
SELECT name, 
       (page_count * page_size) / 1024 / 1024 as size_mb 
FROM pragma_page_count(), pragma_page_size(), sqlite_master 
WHERE type = 'table';

# Monitor row counts
SELECT 'admins' as table_name, COUNT(*) as count FROM admins
UNION
SELECT 'pages', COUNT(*) FROM pages
UNION
SELECT 'messages', COUNT(*) FROM messages
UNION
SELECT 'audit_logs', COUNT(*) FROM audit_logs;
```

## Common Monitoring Alerts

| Issue | Action |
|-------|--------|
| Database > 100 MB | Archive old audit logs |
| Audit logs > 100,000 rows | Delete logs > 90 days old |
| Disk space < 10% | Contact host, may need upgrade |
| 404 errors increasing | Check for broken links or bots |
| Login failures spiking | Possible brute force attempt |
| SSL cert expires soon | Auto-renewal usually handles this |
| PHP errors in logs | Review error, fix code or settings |
| Slow page loads | Optimize database, check server load |

## Scaling Considerations (Future)

When site grows, consider:

```
✓ Upgrade hosting tier (more resources)
✓ Database optimization (indexes, queries)
✓ Content delivery network (CDN) for images
✓ Database migration to MySQL (if outgrowing SQLite)
✓ API layer for scaling to multiple servers
✓ Cache layer (Redis) for frequent queries
✓ Load balancing for multiple servers
```

---

## Appendix A: File Structure Reference

```
freddyinvestments.org/
├── public/
│   ├── index.php              (Main entry point)
│   ├── assets/
│   │   ├── css/style.css
│   │   ├── js/main.js
│   │   └── images/
│   └── uploads/               (User uploaded files)
├── src/
│   ├── bootstrap.php          (Initialize app)
│   ├── Router.php             (URL routing)
│   ├── Auth/
│   │   └── AuthManager.php    (Authentication)
│   ├── Controllers/           (Request handlers)
│   ├── Database/              (DB connection)
│   ├── Middleware/            (Auth checking)
│   ├── Models/                (Data models)
│   └── Views/                 (Templates)
├── storage/
│   ├── cms.db                 (SQLite database)
│   ├── logs/                  (Error logs)
│   └── backups/               (Database backups)
├── setup-database.php         (One-time setup)
├── INSTALLATION.md            (Setup guide)
├── DEPLOYMENT_GUIDE.md        (This file)
├── README_CMS.md              (Quick start)
└── .htaccess                  (URL rewriting)
```

## Appendix B: Quick Command Reference

### Local (XAMPP)

```bash
# Start services
xampp start

# Backup database
copy storage\cms.db storage\cms_backup.db

# Check database
sqlite3 storage/cms.db ".tables"

# Set permissions (if needed)
chmod -R 755 storage
chmod 666 storage/cms.db
```

### Production (SSH)

```bash
# SSH into server
ssh user@your-domain.com

# Navigate to project
cd ~/public_html/freddyinvestments.org

# Set permissions
chmod 755 storage public/uploads
chmod 666 storage/cms.db

# Backup database
cp storage/cms.db storage/cms_backup_$(date +%Y%m%d).db

# Check database integrity
sqlite3 storage/cms.db "PRAGMA integrity_check;"

# Optimize database
sqlite3 storage/cms.db "PRAGMA optimize; VACUUM;"
```

## Appendix C: Support & Documentation

| Resource | Link/Location |
|----------|---------------|
| CMS Quick Start | CMS_QUICK_START.md |
| Full CMS Docs | CMS_DOCUMENTATION.md |
| Implementation Details | CMS_IMPLEMENTATION_SUMMARY.md |
| Installation Guide | INSTALLATION.md |
| This Guide | DEPLOYMENT_GUIDE.md |
| PHP Docs | https://www.php.net |
| SQLite Docs | https://www.sqlite.org |
| Apache .htaccess | https://httpd.apache.org/docs |

---

## Appendix D: Version History

```
v1.0 - May 2026
- Initial complete deployment guide
- Local (XAMPP) setup instructions
- Production (Shared Hosting) setup instructions
- Security hardening guide
- Performance optimization tips
- Troubleshooting section
- Migration guide
- Maintenance procedures
```

---

**Document prepared for Freddy Investments CMS**

Last updated: May 27, 2026

For questions or issues:
1. Check troubleshooting section above
2. Review relevant documentation (INSTALLATION.md, CMS_DOCUMENTATION.md)
3. Contact your hosting provider for server-specific issues
4. Check PHP/Apache logs for detailed error messages

Happy deploying! 🚀
