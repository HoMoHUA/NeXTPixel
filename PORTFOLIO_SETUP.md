# Quick Setup Guide - Portfolio System

## Step 1: Create Database Table

Run this SQL command in your MySQL database:

```bash
mysql -u your_username -p your_database_name < /config/create-portfolio-table.sql
```

Or paste the SQL directly in phpMyAdmin:
1. Go to phpMyAdmin
2. Select your database
3. Click "SQL" tab
4. Paste content from `/config/create-portfolio-table.sql`
5. Click "Go"

## Step 2: Access Portfolio Admin Panel

1. Login to your admin panel at `/panel/`
2. Navigate to **نمونه کارها** (Portfolios) menu
3. Or go directly to: `http://yoursite.com/panel/admin/portfolios.php`

## Step 3: Add Your First Portfolio

Click **"+ افزودن نمونه کار جدید"** and fill in:

### Required Fields:
- **عنوان پروژه:** Project Name
- **توضیح:** Project Description  
- **دسته‌بندی:** Category (فروشگاهی / خدماتی / لندینگ / سایر)
- **مسیر تصویر:** Image path like `/src/project.png`

### Optional Fields:
- **مسیر تصویر محلی:** Local host image alternative
- **لینک وبسایت:** External website URL
- **نوع دمو:** Demo type (خارجی / محلی / هر دو)
- **لینک دمو محلی:** Internal demo path like `/demos/project/`
- **نام کلاینت:** Client name
- **متن Alt:** Image alt text (SEO)
- **نمایش در صفحه اصلی:** Check to feature on homepage
- **ترتیب نمایش:** Display order (0-99)
- **وضعیت:** Status (فعال / غیرفعال / پیش‌نویس)

## Step 4: See Your Portfolios

After adding portfolios, they appear automatically on:
- **Homepage:** `http://yoursite.com/` (featured projects)
- **Portfolio Page:** `http://yoursite.com/portfolio.php` (all projects)

## API Endpoints

### Public (No auth needed):
```
GET /api/get-portfolios.php?action=list
GET /api/get-portfolios.php?action=list&category=store
GET /api/get-portfolios.php?action=featured&limit=6
GET /api/get-portfolios.php?action=categories
```

### Admin (Login required):
```
POST /panel/api/manage-portfolios.php
GET /panel/api/manage-portfolios.php?action=list
GET /panel/api/manage-portfolios.php?action=get&id=1
GET /panel/api/manage-portfolios.php?action=delete&id=1
```

## Loading Demos from Host IP

For projects that need to run on server IP:

1. **In Admin Panel:**
   - Set **نوع دمو** to "محلی" or "هر دو"
   - Enter **لینک دمو محلی:** `/demos/projectname/`

2. **On Portfolio Page:**
   - User clicks "دمو محلی"
   - System automatically uses current host IP
   - Opens: `http://192.168.1.100/demos/projectname/`

## Sticky Headers with Backdrop Filter

All pages now have beautiful glass effect headers:
- ✅ Sticky to top while scrolling
- ✅ Blur effect: 35px with 280% saturation
- ✅ Smooth transitions
- ✅ Mobile responsive

Applied to:
- index.php (صفحه اصلی)
- services.php (خدمات)
- portfolio.php (نمونه کارها)
- about.php (درباره ما)
- contact.php (تماس با ما)

## File Locations Reference

| What | Where |
|------|-------|
| Portfolio Admin | `/panel/admin/portfolios.php` |
| Public Portfolio API | `/api/get-portfolios.php` |
| Admin Portfolio API | `/panel/api/manage-portfolios.php` |
| Database Schema | `/config/create-portfolio-table.sql` |
| Documentation | `/PORTFOLIO_MANAGEMENT.md` |
| Database Table | `portfolios` |

## Troubleshooting

### Portfolios not showing on homepage?
1. Did you check "نمایش در صفحه اصلی"?
2. Is status set to "فعال"?
3. Is JavaScript enabled?
4. Check browser console for errors

### Demo links not working?
- Use paths like `/demos/projectname/` not URLs
- Make sure folder exists on server
- Test URL manually first

### Database error when saving?
- Make sure table exists: Run `/config/create-portfolio-table.sql` again
- Check database connection in config
- Verify user has write permissions

### Headers not looking right?
- Clear browser cache (Ctrl+Shift+Del)
- Check CSS is loading: look for nextpixel-global.css in Network tab
- Try different browser

## Important Notes

✅ **Automatic Features:**
- Categories auto-generate from database
- Featured projects appear on homepage
- Order respects display_order field
- Status controls visibility

✅ **Security:**
- Admin API requires login
- Public API only shows active projects
- Input validation on all fields
- SQL injection protection

## What's New

### Headers
- `sticky top-0 z-50` positioning
- Backdrop filter blur effect
- Smooth scroll animations

### Database
- `portfolios` table with 15 fields
- Support for internal & external demos
- Featured project flags
- Display ordering system

### Admin Panel
- Full CRUD operations
- Category filtering
- Real-time preview
- Modal form interface

### Public APIs
- `/api/get-portfolios.php` - Public access
- `/panel/api/manage-portfolios.php` - Admin access
- Automatic category detection
- JSON responses

## Next Steps

1. ✅ Create portfolio table (SQL file run)
2. ✅ Login to admin panel
3. ✅ Add your portfolio projects
4. ✅ Visit homepage to see changes
5. ✅ Share portfolio page with clients

---

**Ready to go!** 🚀

Questions? Check `/PORTFOLIO_MANAGEMENT.md` for detailed documentation.
