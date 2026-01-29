# NextPixel Website Project

A modern, professional website for NextPixel - a web design and development company based in Iran. This is a Persian (Farsi) language website built with PHP, featuring an elegant dark theme with glass-morphism effects.

## 🌟 Features

### Frontend Features
- **Modern UI/UX Design**: Dark theme with glass-morphism effects and smooth animations
- **Responsive Design**: Fully responsive layout for mobile, tablet, and desktop
- **Video Preloader**: Custom video preloader with progress bar for engaging user experience
- **Interactive Animations**: 
  - AOS (Animate On Scroll) library
  - Vanta.js background animations (Globe, Waves)
  - ScrollReveal animations
  - Anime.js for smooth transitions
- **AI-Powered Chatbot**: Intelligent customer support chatbot using OpenAI GPT-4
- **Service Calculators**: Interactive pricing calculators for WordPress and custom development
- **Portfolio Showcase**: Filterable portfolio gallery
- **Contact Forms**: Multiple contact forms across the site

### Pages
1. **index.php** - Homepage with hero section, services overview, about, portfolio preview, and contact form
2. **services.php** - Detailed services and pricing plans with interactive calculators
3. **about.php** - Company information, team members, and values
4. **portfolio.php** - Portfolio showcase with filtering functionality
5. **contact.php** - Contact information and inquiry form
6. **login.php** - User authentication (login/register) with Google Sign-In support

## 🛠️ Technology Stack

### Frontend
- **CSS Framework**: Tailwind CSS (CDN)
- **Fonts**: Vazirmatn (Persian font)
- **Icons**: Feather Icons
- **Animation Libraries**:
  - AOS (Animate On Scroll)
  - ScrollReveal
  - Anime.js
  - Vanta.js (3D backgrounds)

### Backend
- **Language**: PHP 7.4+
- **Session Management**: PHP Sessions for user authentication

### External Services
- **AI Chatbot**: OpenAI GPT-4 API
- **Proposal Generation**: Google Gemini API (planned)

## 📁 Project Structure

```
NP/
├── index.php           # Homepage
├── about.php           # About page
├── services.php        # Services and pricing
├── portfolio.php       # Portfolio showcase
├── contact.php         # Contact page
├── login.php           # Authentication page
├── auth.php            # [MISSING] Authentication handler
├── api/
│   ├── save-lead.php   # [MISSING] Save chatbot leads
│   └── generate-proposal.php # [MISSING] Generate proposals
├── admin/              # [MISSING] Admin panel
└── src/                # [MISSING] Static assets (images, videos)
    ├── preloadm.mp4    # Mobile preloader video
    ├── preload.mp4     # Desktop preloader video
    └── *.png           # Portfolio images
```

## ⚠️ Missing Files

The following files are referenced in the code but need to be created:

1. **auth.php** - Handle login/registration authentication
2. **api/save-lead.php** - Save chatbot conversation summaries as leads
3. **api/generate-proposal.php** - Generate project proposals using AI
4. **admin/** directory - Admin panel for managing leads, users, etc.
5. **src/** directory - Static assets (images, videos)

## 🔧 Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- Web server (Apache/Nginx)
- Database (MySQL/PostgreSQL) - if implementing full authentication

### Installation Steps

1. **Clone or extract the project**
   ```bash
   cd NP
   ```

2. **Configure your web server**
   - Point your web server document root to the project directory
   - Ensure PHP is enabled

3. **Create missing directories**
   ```bash
   mkdir -p api
   mkdir -p admin
   mkdir -p src
   ```

4. **Set up environment variables**
   - Add your OpenAI API key (currently hardcoded - should be moved to config)
   - Add Google Gemini API key for proposal generation
   - Configure database credentials if needed

5. **Create missing API files**
   - See API implementation section below

6. **Add static assets**
   - Place preloader videos in `src/` directory
   - Add portfolio images to `src/` directory

## 🔐 Security Considerations

⚠️ **IMPORTANT**: The following security improvements should be made:

1. **API Keys**: Currently hardcoded in JavaScript files. Should be moved to:
   - Server-side environment variables
   - Secure configuration files
   - Or use a backend proxy

2. **Authentication**: Implement proper:
   - Password hashing (bcrypt/argon2)
   - CSRF protection
   - SQL injection prevention
   - XSS protection

3. **Input Validation**: Add server-side validation for all forms

## 📝 API Implementation Requirements

### 1. auth.php
```php
<?php
// Handle login and registration
// Validate credentials
// Create sessions
// Return JSON responses
?>
```

### 2. api/save-lead.php
```php
<?php
// Save chatbot conversation summaries
// Store in database or file
// Return success/error response
?>
```

### 3. api/generate-proposal.php
```php
<?php
// Use Google Gemini API
// Generate project proposals
// Return formatted proposal text
?>
```

## 🎨 Customization

### Colors
The website uses a dark theme with:
- Primary: Blue (#3b82f6)
- Secondary: Purple (#8b5cf6)
- Accent: Amber (#f59e0b)

### Fonts
- Primary: Vazirmatn (Persian font)
- Loaded from Google Fonts CDN

### Animations
- Modify animation durations in AOS initialization
- Adjust Vanta.js settings for different background effects

## 📱 Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Internet Explorer not supported
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🚀 Performance Tips

1. **Optimize Images**: Compress portfolio images
2. **CDN Usage**: Consider moving libraries to local files
3. **Caching**: Implement browser caching for static assets
4. **Lazy Loading**: Add lazy loading for images
5. **Video Optimization**: Compress preloader videos

## 📞 Contact Information

- Email: project@hojat.sbs
- Phone: 0920 940 9493, 0999 980 9570
- Address: مشهد، قاسم آباد، برج ایلما، واحد 202

## 📄 License

© 2025 NextPixel. All rights reserved.

## 🔄 TODO

- [ ] Create missing API files (auth.php, save-lead.php, generate-proposal.php)
- [ ] Implement admin panel
- [ ] Move API keys to secure configuration
- [ ] Add database integration
- [ ] Implement proper authentication system
- [ ] Add form validation and CSRF protection
- [ ] Optimize images and videos
- [ ] Add error logging
- [ ] Create API documentation
- [ ] Add unit tests

## 🤝 Contributing

This is a private project. For questions or contributions, please contact the development team.

---

**Note**: This project is actively under development. Some features may be incomplete or require additional setup.

