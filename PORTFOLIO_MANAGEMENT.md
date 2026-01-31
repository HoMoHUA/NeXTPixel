# Portfolio Management System - Documentation

## Overview
Complete portfolio management system for NextPixel with database-driven content, sticky headers with backdrop filter effects, and admin panel for CRUD operations.

## Changes Implemented

### 1. **Header Styling & Sticky Effects**
✅ **All main pages updated with:**
- `sticky top-0 z-50` classes for persistent headers
- `ios-glass-header` class with backdrop blur filter (`blur(35px) saturate(280%)`)
- Works across all general pages:
  - index.php (homepage)
  - services.php
  - portfolio.php
  - about.php
  - contact.php

**CSS Implementation:**
```css
.ios-glass-header {
    position: sticky;
    top: 0;
    z-index: 50;
    backdrop-filter: blur(35px) saturate(280%);
    -webkit-backdrop-filter: blur(35px) saturate(280%);
}

.ios-glass-header.scrolled {
    /* Enhanced blur on scroll */
}
```

---

### 2. **Database Structure**

#### New Table: `portfolios`
**Location:** `/config/create-portfolio-table.sql`

**Fields:**
| Field | Type | Description |
|-------|------|-------------|
| `id` | INT | Primary key |
| `title` | VARCHAR(255) | Project name |
| `description` | TEXT | Project description |
| `category` | VARCHAR(50) | store, service, landing, other |
| `thumbnail` | VARCHAR(500) | Image path/URL |
| `thumbnail_local_path` | VARCHAR(500) | Local host alternative image |
| `project_url` | VARCHAR(500) | External project link |
| `demo_type` | ENUM | external, internal, both |
| `internal_demo_url` | VARCHAR(500) | Local/internal demo link |
| `image_alt_text` | VARCHAR(500) | Alt text for SEO |
| `technologies` | JSON | Array of tech stack |
| `client_name` | VARCHAR(255) | Client name |
| `completion_date` | DATE | Project completion date |
| `featured` | BOOLEAN | Show on homepage |
| `display_order` | INT | Sort order |
| `status` | ENUM | active, inactive, draft |
| `created_at` | TIMESTAMP | Creation timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |
| `created_by` | INT | Admin user ID who created |

**Setup Command:**
```bash
mysql -u username -p database_name < /config/create-portfolio-table.sql
```

---

### 3. **Admin Panel - Portfolio Manager**

**Location:** `/panel/admin/portfolios.php`

**Features:**
- ✅ View all portfolios with filtering
- ✅ Add new portfolio projects
- ✅ Edit existing portfolios
- ✅ Delete portfolios
- ✅ Filter by category (فروشگاهی, خدماتی, لندینگ)
- ✅ Status management (فعال, غیرفعال, پیش‌نویس)
- ✅ Display order management
- ✅ Featured project selection
- ✅ Demo type selection (خارجی, محلی, هر دو)

**Access:** 
- Only authenticated users can access
- Panel path: `/panel/admin/portfolios.php`

**UI Features:**
- Glass morphism design
- Real-time filtering
- Modal form for add/edit
- Responsive grid layout
- Status badges
- Quick action buttons

---

### 4. **API Endpoints**

#### Admin API
**Location:** `/panel/api/manage-portfolios.php`

**Actions:**

##### List
```
GET /panel/api/manage-portfolios.php?action=list&category=all&status=active
```
Returns all portfolios with filtering options

##### Get Single
```
GET /panel/api/manage-portfolios.php?action=get&id=1
```
Returns specific portfolio details

##### Create
```
POST /panel/api/manage-portfolios.php
Content-Type: application/json

{
  "action": "create",
  "title": "Project Name",
  "description": "Project description",
  "category": "store",
  "thumbnail": "/src/image.png",
  "project_url": "https://example.com",
  "demo_type": "external",
  "featured": true,
  "status": "active"
}
```

##### Update
```
POST /panel/api/manage-portfolios.php
Content-Type: application/json

{
  "action": "update",
  "id": 1,
  "title": "Updated Title",
  ...
}
```

##### Delete
```
GET /panel/api/manage-portfolios.php?action=delete&id=1
```

##### Reorder
```
POST /panel/api/manage-portfolios.php
Content-Type: application/json

{
  "action": "reorder",
  "items": {
    "0": 1,
    "1": 3,
    "2": 2
  }
}
```

#### Public API
**Location:** `/api/get-portfolios.php`

**Actions:**

##### List All Active
```
GET /api/get-portfolios.php?action=list&category=all
GET /api/get-portfolios.php?action=list&category=store
GET /api/get-portfolios.php?action=list&category=service
```

##### Get Featured (for Homepage)
```
GET /api/get-portfolios.php?action=featured&limit=6
```
Returns featured portfolios for homepage display

##### Get Categories
```
GET /api/get-portfolios.php?action=categories
```
Returns list of all available categories

---

### 5. **Homepage Integration**

**File:** `index.php` (lines ~313-350)

**Features:**
- Dynamically loads featured portfolios from database
- Automatic AOS animation refresh
- Responsive grid (1 col mobile, 2 cols tablet, 3 cols desktop)
- Fallback placeholder images
- Graceful error handling

**Loading Code:**
```javascript
fetch('/api/get-portfolios.php?action=featured&limit=6')
    .then(r => r.json())
    .then(portfolios => {
        // Render portfolios with animations
    })
```

---

### 6. **Portfolio Page Enhancements**

**File:** `portfolio.php`

**Features:**
- ✅ Dynamic category filtering
- ✅ Auto-generated category buttons from database
- ✅ Dual demo options (External & Internal/Local)
- ✅ Demo modal dialog
- ✅ Host-aware demo URL loading
- ✅ Alt text from database for SEO
- ✅ Color-coded category badges
- ✅ Real-time filtering

**Demo Loading Logic:**
```javascript
function openDemo(url) {
    if (url.startsWith('/')) {
        // Local demo - use current host
        window.open(window.location.protocol + '//' + window.location.host + url, '_blank');
    } else {
        window.open(url, '_blank');
    }
}
```

---

## How to Use

### Add New Portfolio Project

1. **Go to Panel:** Navigate to `/panel/admin/portfolios.php`
2. **Click "Add New Project"** button
3. **Fill in Details:**
   - **Title:** Project name
   - **Description:** Brief project description
   - **Category:** Choose from فروشگاهی, خدماتی, لندینگ, سایر
   - **Thumbnail:** Path to project image (e.g., `/src/project.png`)
   - **Local Thumbnail:** Optional local host alternative
   - **Project URL:** External website link
   - **Demo Type:** 
     - **External:** Link to live website only
     - **Internal:** Local/internal demo link only
     - **Both:** Both options available
   - **Client Name:** Name of the client
   - **Alt Text:** SEO-friendly image description
   - **Featured:** Check to show on homepage
   - **Display Order:** Set priority (0-99)
   - **Status:** Active, Inactive, or Draft

4. **Click Save** - Project appears on portfolio page immediately

### Edit Existing Project

1. Find project in portfolio grid
2. Click **"Edit"** button
3. Modify details
4. Click **Save**

### Delete Project

1. Click **"Delete"** button
2. Confirm deletion
3. Project removed from all pages

### Load from Host IP

When a demo requires the server's IP address:

1. **Set Demo Type** to "Internal" or "Both"
2. **Enter Demo URL** like `/demos/project-name/`
3. System automatically uses current host IP
4. Users see option to open local demo

**Example:**
- Local demo URL: `/demos/hchperfume/`
- When user clicks: Opens `http://192.168.1.100/demos/hchperfume/`
- (Automatically uses current server IP)

---

## Database Migration

### Create Table
```sql
-- Run this to create the portfolio table
mysql -u root -p your_database < /config/create-portfolio-table.sql
```

### Sample Data
The SQL file includes 5 sample portfolios already populated.

### Check Data
```sql
SELECT * FROM portfolios;
SELECT COUNT(*) FROM portfolios WHERE status = 'active';
SELECT DISTINCT category FROM portfolios;
```

---

## Styling & CSS

### Portfolio Card
```css
.portfolio-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.portfolio-card:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
}
```

### Category Colors
- 🔵 **Store:** Blue (فروشگاهی)
- 🟣 **Service:** Purple (خدماتی)
- 🟠 **Landing:** Amber (لندینگ)
- ⚫ **Other:** Gray (سایر)

---

## File Structure

```
NeXTPixel/
├── config/
│   └── create-portfolio-table.sql          # Database schema
├── api/
│   └── get-portfolios.php                  # Public portfolio API
├── panel/
│   ├── admin/
│   │   └── portfolios.php                  # Admin portfolio manager
│   └── api/
│       └── manage-portfolios.php           # Admin API
├── index.php                                # Updated with dynamic portfolio
├── portfolio.php                            # Enhanced portfolio page
├── services.php                             # Updated header
├── about.php                                # Updated header
├── contact.php                              # Updated header
└── assets/
    └── css/
        └── nextpixel-global.css            # Contains .ios-glass-header
```

---

## Features Summary

| Feature | Location | Status |
|---------|----------|--------|
| Sticky Glass Headers | All pages | ✅ Complete |
| Portfolio Database | portfolios table | ✅ Complete |
| Admin CRUD Panel | /panel/admin/portfolios.php | ✅ Complete |
| Public Portfolio API | /api/get-portfolios.php | ✅ Complete |
| Admin Portfolio API | /panel/api/manage-portfolios.php | ✅ Complete |
| Homepage Integration | index.php | ✅ Complete |
| Dynamic Filtering | portfolio.php | ✅ Complete |
| Host-based Demo Loading | portfolio.php | ✅ Complete |
| Category Management | Auto-generated | ✅ Complete |
| Featured Projects | Database flag | ✅ Complete |
| Display Ordering | display_order field | ✅ Complete |

---

## Performance Considerations

- **Caching:** Portfolio data can be cached for 1 hour on homepage
- **Images:** Use optimized images (max 500KB thumbnails)
- **Lazy Loading:** Images load on-demand
- **Database Indexes:** Applied to category, status, featured, display_order
- **Pagination:** Can be added for 100+ projects

---

## SEO Optimization

- Each portfolio has:
  - `image_alt_text` for image SEO
  - `description` for meta content
  - `title` for heading SEO
  - Proper heading structure (H1, H2, H3)
  - Structured data ready for JSON-LD

---

## Security Notes

- ✅ Admin API requires session authentication
- ✅ Public API returns only active projects
- ✅ Input validation on all forms
- ✅ SQL injection protection via prepared statements
- ✅ CSRF protection via session tokens

---

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers
- ✅ Backdrop filter fallback for older browsers

---

## Troubleshooting

### Portfolios not showing?
1. Check database connection
2. Verify portfolios table exists
3. Check status is "active"
4. Verify API endpoint works: `/api/get-portfolios.php?action=list`

### Demo link not working?
1. Verify `demo_type` is set correctly
2. Check `internal_demo_url` path exists
3. Test URL works on current host

### Headers not sticky?
1. Check CSS is loaded: `/assets/css/nextpixel-global.css`
2. Verify `sticky top-0 z-50` classes present
3. Check z-index conflicts with other elements

---

## Contact & Support

For issues or questions:
- Check `/panel/admin/portfolios.php` for management
- Review database structure in `/config/create-portfolio-table.sql`
- Test APIs at `/api/get-portfolios.php`

---

**Last Updated:** January 31, 2026
**Version:** 1.0.0
**Status:** Production Ready ✅
