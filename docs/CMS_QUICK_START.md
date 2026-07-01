# Freddy Investments CMS - Quick Start Guide

## 🚀 Quick Setup (5 minutes)

### Step 1: Initialize Database
```bash
# Open your browser and go to:
http://localhost/freddyinvestments.org/setup-database.php
```
This will:
- Create all database tables
- Set up default admin user
- Configure business settings

### Step 2: Login to Admin Panel
```
URL: http://localhost/freddyinvestments.org/admin/login
Use your assigned credentials
```

### Step 3: Change Your Password
Go to **Settings** and update the admin password immediately.

### Step 4: Start Managing Content!

---

## 📋 Admin Panel Navigation

| Section | Purpose | What You Can Do |
|---------|---------|-----------------|
| **Dashboard** | Overview | View stats, recent messages, quick actions |
| **Pages** | Website pages | Create/edit about, services pages, etc. |
| **Services** | Your services | List and manage company services |
| **Tips** | Articles/tips | Publish helpful content for customers |
| **Quotes** | Testimonials | Showcase client reviews and ratings |
| **Messages** | Contacts | View form submissions, reply to inquiries |
| **Assets** | Media library | Upload and manage images, documents |
| **Settings** | Configuration | Business info, contact, social media |

---

## 🎯 Common Workflows

### Adding a New Service

1. Click **Services** in sidebar
2. Click **Create New Service**
3. Fill in:
   - Service name (e.g., "Landscape Design")
   - Slug (e.g., "landscape-design")
   - Description
   - Status: Active/Inactive
4. Click **Create Service**

### Uploading Images

1. Go to **Assets**
2. Click **Upload File**
3. Select image from your computer
4. Add alt text (important for SEO)
5. Click **Upload**
6. Images are available for use throughout site

### Publishing a Page

1. Click **Pages**
2. Click **Create New Page**
3. Fill in:
   - Title
   - Slug (URL-friendly name)
   - Content
   - Meta Description (for search engines)
4. Set Status to **Published**
5. Click **Create Page**

### Responding to Customer Messages

1. Go to **Messages**
2. Find unread message (red badge)
3. Click **View**
4. Read full message and customer contact info
5. Type your **Response**
6. Click **Send Reply**

---

## 🔐 Security Tips

- ✅ Change default admin password on first login
- ✅ Never share admin credentials
- ✅ Log out when finished
- ✅ Delete `setup-database.php` after use
- ✅ Keep backups of `storage/database.sqlite`

---

## 📁 File Structure

```
/admin/login          ← Admin login page
/admin/dashboard      ← Main admin area
/admin/pages          ← Manage pages
/admin/services       ← Manage services
/admin/tips           ← Manage tips
/admin/quotes         ← Manage testimonials
/admin/messages       ← View contact messages
/admin/assets         ← Manage media files
/admin/settings       ← Configure business info
```

---

## ❓ FAQ

**Q: How do I make a page visible on the website?**  
A: Set its status to "Published" when creating/editing.

**Q: Can I upload videos?**  
A: Currently images (JPG, PNG, GIF) and PDFs. Videos can be embedded via links.

**Q: What file size limit is there?**  
A: 5MB maximum per file.

**Q: How long until I'm logged out?**  
A: 30 minutes of inactivity for security.

**Q: Can I add multiple admin users?**  
A: Yes, through the database or admin panel (if user management is added).

**Q: Where are my uploads stored?**  
A: In `/public/uploads/` directory.

**Q: How do I backup the database?**  
A: Copy `storage/database.sqlite` to a safe location.

---

## 🆘 Troubleshooting

**Can't login?**
- Ensure you're using correct username/password
- Clear browser cookies and try again
- Check that database was initialized

**Upload button not working?**
- Check that `/public/uploads/` directory exists
- Verify file is under 5MB
- Check file type is supported (JPG, PNG, GIF, PDF)

**Pages not showing on website?**
- Set status to "Published"
- Check page slug is correct
- Verify page content is visible in frontend views

**Messages not appearing?**
- Contact form must be submitting to `/contact/submit`
- Check browser console for JavaScript errors
- Verify CSRF token is being sent

---

## 📞 Support

For detailed documentation, see: **CMS_DOCUMENTATION.md**

---

**Happy Managing! 🎉**
