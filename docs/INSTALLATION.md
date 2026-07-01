# 🎉 Admin CMS Installation & Setup Guide

## Prerequisites

- PHP 7.4 or higher
- SQLite3 support enabled (built into PHP)
- Web server (Apache/Nginx)
- XAMPP or similar local development environment

## Installation Steps

### 1. Files Already in Place ✅

The following have been created and integrated:

```
✅ Database Layer
   - Database.php (SQLite connection)
   - DatabaseInitializer.php (schema creation)

✅ Models (ORM)
   - Model.php (base class)
   - Admin, Page, Service, Tip, Quote, Asset, Message, BusinessSetting

✅ Controllers
   - AdminAuthController (login/logout)
   - AdminDashboardController (main dashboard)
   - AdminPagesController (CRUD for pages)
   - AdminServicesController (CRUD for services)
   - AdminTipsController (CRUD for tips)
   - AdminQuotesController (CRUD for testimonials)
   - AdminMessagesController (message management)
   - AdminAssetsController (media management)
   - AdminSettingsController (business settings)

✅ Authentication & Security
   - AuthManager (session management)
   - AuthMiddleware (route protection)

✅ Admin Views (UI)
   - Login page
   - Dashboard
   - CRUD forms and lists for all modules
   - Responsive design with Tailwind CSS

✅ Routes
   - Admin routes in public/index.php
   - Parameterized routing support

✅ Documentation
   - CMS_DOCUMENTATION.md (comprehensive guide)
   - CMS_QUICK_START.md (quick reference)
```

### 2. Directory Verification

Ensure these directories exist:

```bash
# Create if missing
mkdir -p storage
mkdir -p storage/logs
mkdir -p public/uploads
```

Set permissions:
```bash
chmod 755 storage
chmod 755 storage/logs
chmod 755 public/uploads
```

### 3. Initialize Database

**Option A: Via Browser (Easiest)**
1. Open `http://localhost/freddyinvestments.org/setup-database.php` in your browser
2. Follow the on-screen instructions
3. Database will be created with default admin user

**Option B: Via Command Line**
```bash
cd /path/to/freddyinvestments.org
php setup-database.php
```

### 4. First Login

After initialization:
- Navigate to: `http://localhost/freddyinvestments.org/admin/login`
- Use your assigned credentials to login
- ⚠️ Change your password immediately!

### 5. Security Steps

1. **Change Default Admin Password**
   - Login to admin panel
   - Go to Settings
   - Update admin password

2. **Delete Setup File** (Optional but recommended)
   - Delete `setup-database.php` after use
   - It's only needed once

3. **Set File Permissions**
   ```bash
   # Make database directory writable
   chmod 755 storage
   
   # Make uploads directory writable
   chmod 755 public/uploads
   ```

4. **Enable HTTPS**
   - Use SSL in production
   - Update `.env` with secure URL

---

## Usage

### Accessing Admin Panel

Main URLs:
```
Login:      http://localhost/freddyinvestments.org/admin/login
Dashboard:  http://localhost/freddyinvestments.org/admin/dashboard
Pages:      http://localhost/freddyinvestments.org/admin/pages
Services:   http://localhost/freddyinvestments.org/admin/services
Tips:       http://localhost/freddyinvestments.org/admin/tips
Quotes:     http://localhost/freddyinvestments.org/admin/quotes
Messages:   http://localhost/freddyinvestments.org/admin/messages
Assets:     http://localhost/freddyinvestments.org/admin/assets
Settings:   http://localhost/freddyinvestments.org/admin/settings
```

### Managing Content

Each section follows the same pattern:

1. **List View** - See all items, with edit/delete options
2. **Create Form** - Add new content with validation
3. **Edit Form** - Modify existing content
4. **Delete** - Remove with confirmation

---

## Database Structure

### Key Tables

| Table | Purpose | Key Fields |
|-------|---------|-----------|
| admins | Admin users | username, email, password_hash |
| pages | Website pages | title, slug, content, status |
| services | Company services | name, description, status |
| tips | Tips/articles | title, content, category, status |
| quotes | Testimonials | client_name, quote_text, rating |
| messages | Contact submissions | name, email, message, status |
| assets | Media files | filename, filepath, mime_type |
| business_settings | Configuration | setting_key, setting_value |
| audit_logs | Activity tracking | admin_id, action, entity_type |

---

## Architecture

### Modular Design

```
App/
├── Database/        ← Data access layer
├── Models/          ← Business logic
├── Controllers/     ← Request handling
├── Auth/            ← Authentication
├── Middleware/      ← Route protection
└── Views/           ← UI templates
```

### Request Flow

```
1. Request → Router
2. Router → Controller
3. Controller → Middleware (Auth check)
4. Controller → Model (Data)
5. Model → Database
6. Response → View (Render)
```

---

## Features Provided

### 📄 Content Management
- ✅ Pages CRUD with draft/publish status
- ✅ Services management with ordering
- ✅ Tips/Articles with categories
- ✅ Testimonials with ratings
- ✅ SEO metadata for pages

### 💬 Communication
- ✅ Contact message inbox
- ✅ Message view/reply functionality
- ✅ Unread message tracking
- ✅ Email contact quick links

### 🖼️ Media Management
- ✅ Image upload with validation
- ✅ Alt text for accessibility
- ✅ File size limits (5MB)
- ✅ Organized gallery view

### ⚙️ Settings
- ✅ Business info management
- ✅ Contact information
- ✅ Social media links
- ✅ Business hours
- ✅ Company description

### 🔒 Security
- ✅ Admin authentication
- ✅ CSRF protection
- ✅ Password hashing (bcrypt)
- ✅ Session management (30-min timeout)
- ✅ SQL injection protection (prepared statements)
- ✅ XSS prevention (HTML escaping)

### 📊 Analytics
- ✅ Dashboard statistics
- ✅ Message tracking
- ✅ Audit logs
- ✅ Activity timestamps

---

## Troubleshooting

### Database Won't Initialize

**Error: "Database connection failed"**
- Solution: Ensure `storage/` directory exists and is writable
  ```bash
  mkdir storage && chmod 755 storage
  ```

### Can't Upload Files

**Error: "Failed to upload file"**
- Solution: Check `/public/uploads/` directory permissions
  ```bash
  mkdir -p public/uploads && chmod 755 public/uploads
  ```

### Login Fails

**Error: "Invalid username or password"**
- Solution: Re-run setup script to recreate default admin user
  - Delete `storage/database.sqlite`
  - Rerun `setup-database.php`

### CSRF Token Error

**Error: "Invalid security token"**
- Solution: Clear browser cookies and session
- Ensure `.env` has correct `APP_URL` set

### Routing Issues

**Error: "Page not found"**
- Solution: Verify `.htaccess` file exists in `/public/`
- Check that `?route=` parameter is being set

---

## Configuration

### `.env` File

```ini
APP_ENV=development
APP_URL=http://localhost/freddyinvestments.org
APP_DEBUG=true

# Session config
SESSION_TIMEOUT=1800
```

### Database Location

Database file location: `storage/database.sqlite`

To backup:
```bash
cp storage/database.sqlite storage/database.sqlite.backup
```

---

## Deployment Checklist

Before going live:

- [ ] Change default admin password
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Enable HTTPS/SSL
- [ ] Remove or secure `setup-database.php`
- [ ] Backup database file
- [ ] Set proper file permissions (644 for files, 755 for directories)
- [ ] Configure email for message replies
- [ ] Test all CRUD operations
- [ ] Verify file uploads work
- [ ] Test contact form submission
- [ ] Review security headers

---

## Next Steps

1. **Read Documentation**
   - CMS_DOCUMENTATION.md (detailed guide)
   - CMS_QUICK_START.md (quick reference)

2. **Customize**
   - Update business settings
   - Add your company information
   - Configure social media links

3. **Create Content**
   - Add services
   - Create tips/articles
   - Add testimonials

4. **Monitor**
   - Check messages regularly
   - Respond to inquiries
   - Update content periodically

---

## Support

For issues or questions:
1. Check CMS_DOCUMENTATION.md
2. Review error logs in `storage/logs/`
3. Check browser console for JavaScript errors
4. Verify file permissions

---

**Installation Complete!** 🎉

Your admin CMS is ready to use. Login at:
`http://localhost/freddyinvestments.org/admin/login`
