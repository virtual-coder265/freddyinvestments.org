# Freddy Investments - Admin CMS Documentation

## Overview

A page-centric WordPress-grade admin CMS for Freddy Investments. Content is organized around **Site Pages** (Homepage, About, Services, Portfolio, Contact), a **Content Library** for entities, and **Settings & Tools**.

## Admin Navigation (2026 Restructure)

| Group | Items |
|-------|-------|
| **Dashboard** | Stats, recent messages, activity feed, quick actions |
| **Site Pages** | Homepage, About, Services Page, Portfolio Page, Contact Page — tabbed section editors with preview links |
| **Content Library** | Services, Projects, Testimonials, Tips & Blog |
| **Media Library** | Upload, grid/list view, media picker modal |
| **Settings & Tools** | Tabbed settings (General, Contact, Social & SEO), Messages inbox, Activity Log |

### Key Routes

- Site editors: `/admin/site/home`, `/admin/site/about`, etc.
- Media: `/admin/media`
- Activity log: `/admin/activity`
- Public tips: `/tips`, `/tips/{slug}`

Legacy routes `/admin/content`, `/admin/pages`, and `/admin/assets` redirect to the new structure.

## Features

### Site Page Editors
- Tabbed section editors per public page (Homepage has full control: hero, metrics, welcome, quote form, service cards, why choose us, featured projects copy, testimonials toggle, footer metrics, latest tips block)
- Per-page save with preview link
- Schema defined in `src/Admin/ContentSchema.php`

### Services Management
- Manage company services
- Organize with custom order
- Status control (active/inactive)
- Icon and image support
- Bulk ordering

### 💡 **Tips & Articles**
- Create tips and educational content
- Categorize by topic
- Media attachments
- Status management

### ⭐ **Testimonials & Quotes**
- Manage client testimonials
- Star rating system (1-5)
- Client information storage
- Status control

### 💬 **Message Management**
- View contact form submissions
- Mark as read/unread
- Reply to messages
- Track conversation status
- Delete old messages

### 🖼️ **Asset Management**
- Upload and organize media files
- Support for images (JPG, PNG, GIF) and documents (PDF)
- File size limits (5MB max)
- Alt text for accessibility
- Organized gallery view

### ⚙️ **Business Settings**
- Site information (name, description)
- Contact details (email, phone, address)
- Social media links (Facebook, Instagram, Twitter, LinkedIn)
- Business hours
- Company description
- Centralized configuration

### 🔒 **Security Features**
- Admin authentication with bcrypt password hashing
- CSRF token protection on all forms
- Session timeout (30 minutes)
- Rate limiting on contact form
- IP validation for setup script
- Secure cookie configuration

## Getting Started

### 1. Database Setup

Run the database initialization script to create all tables and default admin user:

```bash
# Via command line
php setup-database.php

# Via browser
http://localhost/freddyinvestments.org/setup-database.php
```

**Default Admin Account:**
- An initial admin account is created during setup
- Use your assigned credentials to login

⚠️ **IMPORTANT:** Change your admin credentials immediately after first login!

### 2. Access the Admin Panel

Navigate to: `http://localhost/freddyinvestments.org/admin/login`

### 3. Dashboard Overview

The admin dashboard displays:
- Quick statistics (pages, services, unread messages)
- Recent contact messages
- Quick action buttons for creating new content
- User information

## Project Structure

```
src/
├── Database/
│   ├── Database.php          # SQLite connection manager
│   └── DatabaseInitializer.php # Schema creation
├── Models/
│   ├── Model.php            # Base model class
│   ├── Admin.php            # Admin user model
│   ├── Page.php             # Page model
│   ├── Service.php          # Service model
│   ├── Tip.php              # Tip model
│   ├── Quote.php            # Quote/testimonial model
│   ├── Asset.php            # Media asset model
│   ├── Message.php          # Contact message model
│   └── BusinessSetting.php  # Settings model
├── Controllers/
│   ├── AdminAuthController.php      # Login/logout
│   ├── AdminDashboardController.php # Dashboard
│   ├── AdminPagesController.php     # Page CRUD
│   ├── AdminServicesController.php  # Service CRUD
│   ├── AdminTipsController.php      # Tip CRUD
│   ├── AdminQuotesController.php    # Quote CRUD
│   ├── AdminMessagesController.php  # Message management
│   ├── AdminAssetsController.php    # Asset management
│   └── AdminSettingsController.php  # Settings management
├── Auth/
│   └── AuthManager.php      # Authentication logic
├── Middleware/
│   └── AuthMiddleware.php   # Auth protection middleware
└── Views/admin/
    ├── layout/
    │   ├── header.php       # Admin header/sidebar
    │   └── footer.php       # Admin footer
    ├── auth/login.php       # Login form
    ├── dashboard.php        # Dashboard
    ├── pages/               # Page views
    ├── services/            # Service views
    ├── tips/                # Tip views
    ├── quotes/              # Quote views
    ├── messages/            # Message views
    ├── assets/              # Asset views
    └── settings/            # Settings views

storage/
└── database.sqlite          # SQLite database file
```

## Database Schema

### Tables

- **admins**: Admin user accounts
- **pages**: Website pages (title, content, slug, status)
- **services**: Business services
- **tips**: Tips and articles
- **quotes**: Client testimonials
- **assets**: Uploaded media files
- **messages**: Contact form submissions
- **business_settings**: Configuration key-value pairs
- **audit_logs**: System activity tracking

## Using the CMS

### Managing Pages

1. Navigate to **Pages** in the sidebar
2. Click **Create New Page** to add a new page
3. Fill in title, slug, and content
4. Set status (Draft/Published)
5. Add SEO metadata
6. Save and view on website

### Managing Services

1. Go to **Services**
2. Create new services with names and descriptions
3. Control visibility with status toggle
4. Reorder services by updating position

### Managing Messages

1. Go to **Messages**
2. View unread messages (highlighted in red)
3. Click to view full message details
4. Reply to customer inquiries
5. Mark as resolved

### Uploading Assets

1. Navigate to **Assets**
2. Click **Upload File**
3. Select image or PDF (max 5MB)
4. Add alt text and description
5. Asset is immediately available for use

### Configuring Settings

1. Go to **Settings**
2. Update company information
3. Add social media links
4. Modify contact details
5. Save changes

## API Reference

### Models

All models extend the base `Model` class with these methods:

```php
// Fetch
Model::find($id)                    // Get by ID
Model::all()                        // Get all records
Model::where($column, $operator, $value)  // Query
Model::firstWhere($column, $value)  // First match
Model::count($where, $params)       // Count records

// Create/Update
Model::create($data)                // Create record
$model->update($data)               // Update record
$model->delete()                    // Delete record
```

### Authentication

```php
use App\Auth\AuthManager;

AuthManager::attempt($username, $password)  // Login
AuthManager::check()                        // Is authenticated
AuthManager::user()                         // Get current user
AuthManager::logout()                       // Logout
AuthManager::id()                           // Get user ID
AuthManager::hasRole($role)                 // Check role
```

### Middleware

```php
use App\Middleware\AuthMiddleware;

// In controller __construct():
AuthMiddleware::handle()                    // Check auth
AuthMiddleware::requireRole('admin')        // Check role
```

## Security Best Practices

1. **Change Default Password**: Update the admin password immediately after setup
2. **Use HTTPS**: Ensure the site uses HTTPS in production
3. **Regular Backups**: Back up `storage/database.sqlite` regularly
4. **Update Software**: Keep PHP and dependencies current
5. **Delete Setup Script**: Remove `setup-database.php` after initialization
6. **File Permissions**: Set proper permissions on storage directory
7. **Admin Access**: Limit admin panel access by IP if possible

## Common Tasks

### Add a New Admin User

```php
use App\Models\Admin;

Admin::create([
    'username' => 'newadmin',
    'email' => 'newadmin@example.com',
    'password_hash' => password_hash('securepassword', PASSWORD_BCRYPT),
    'full_name' => 'Admin Name',
    'role' => 'admin',
    'status' => 'active'
]);
```

### Get All Published Pages

```php
use App\Models\Page;

$pages = Page::where('status', '=', 'published');
```

### Get Business Setting

```php
use App\Models\BusinessSetting;

$siteName = BusinessSetting::get('site_name', 'Default Name');
```

### Get Unread Messages

```php
use App\Models\Message;

$unread = Message::where('status', '=', 'unread');
```

## Troubleshooting

### Database File Not Found

Ensure the `storage/` directory exists and is writable:
```bash
mkdir storage
chmod 755 storage
```

### Permission Denied on Upload

Set proper permissions on uploads directory:
```bash
chmod 755 public/uploads
```

### Session Timeout Too Quick

Adjust session timeout in `AdminAuthController`:
```php
// Change timeout in checkSessionTimeout() - default is 1800 seconds (30 minutes)
```

### CSRF Token Validation Fails

Ensure sessions are enabled in PHP and the app URL is set in `.env`

## Support & Maintenance

- Database is stored as SQLite file for easy portability
- All media files stored in `public/uploads/`
- Logs available in `storage/logs/`
- Audit trail available in `audit_logs` table

## Future Enhancements

Potential features to add:
- Email notification system for messages
- User roles and permissions
- Content versioning/rollback
- Bulk actions on items
- Advanced search and filtering
- REST API for headless CMS usage
- Multi-language support
- Content scheduling

---

**Version**: 1.0  
**Last Updated**: 2024  
**Author**: Freddy Investments Development Team
