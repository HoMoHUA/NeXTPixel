# NextPixel Global CSS & Asset Management

## Overview

All NextPixel styles have been consolidated into a global CSS file with local-first asset hosting. This eliminates external CDN dependencies for styling and fonts while maintaining all visual effects and animations.

## File Structure

```
nextpixel/
├── assets/
│   ├── css/
│   │   └── nextpixel-global.css          # Master stylesheet (all styles)
│   └── fonts/
│       ├── Vazirmatn-Regular.woff2       # Weight 400
│       ├── Vazirmatn-Bold.woff2          # Weight 700
│       ├── Vazirmatn-ExtraBold.woff2     # Weight 800
│       └── Vazirmatn-Black.woff2         # Weight 900
├── scripts/
│   └── download-fonts.py                 # Font downloader utility
├── index.php                             # Homepage
├── about.php
├── services.php
├── portfolio.php
├── contact.php
├── n8n-admin.php
└── [other pages]
```

## CSS Architecture

### Naming Convention

All NextPixel components use the `np-` prefix to avoid namespace conflicts:

- `.np-glass-effect` - Glass morphism components
- `.np-gradient-text` - Gradient text effects
- `.np-ios-glass-header` - Sticky navigation header
- `.np-cta-button` - Call-to-action buttons
- `.np-service-card` - Service showcase cards
- `.np-portfolio-card` - Portfolio items
- `.np-hero-3d-*` - 3D hero section effects
- `.np-container` - Responsive container

### CSS Variables (Root)

The CSS file defines NextPixel color and styling variables:

```css
:root {
    --np-dark-bg: #0f172a;
    --np-dark-bg-alt: #1e293b;
    --np-text-primary: #f8fafc;
    --np-gradient-blue: #3b82f6;
    --np-gradient-purple: #8b5cf6;
    --np-glass-blur: 12px;
    --np-glass-saturate: 180%;
}
```

### Animation Keyframes

All animations use the `np-` prefix:

- `@keyframes np-morph` - Liquid morphing effect
- `@keyframes np-pulse-glow` - Glowing pulse animation
- `@keyframes np-float` - Floating motion
- `@keyframes np-hero-word-3d` - 3D word entry effect
- `@keyframes np-rotate-gradient` - Rotating gradient backgrounds
- And many more...

### Backward Compatibility

Legacy class names (without `np-` prefix) are aliased to new namespaced classes:

```css
.glass-effect { /* maps to np-glass-effect */ }
.gradient-text { /* maps to np-gradient-text */ }
.ios-glass-header { /* maps to np-ios-glass-header */ }
```

This ensures existing HTML markup continues to work without modification.

## Font Management

### Local Fonts

All Vazirmatn font variants are now self-hosted:

1. **Regular** (weight 400) - `Vazirmatn-Regular.woff2`
2. **Bold** (weight 700) - `Vazirmatn-Bold.woff2`
3. **ExtraBold** (weight 800) - `Vazirmatn-ExtraBold.woff2`
4. **Black** (weight 900) - `Vazirmatn-Black.woff2`

### Font Face Declarations

Located in `nextpixel-global.css` (lines 20-48):

```css
@font-face {
    font-family: 'Vazirmatn';
    src: url('/assets/fonts/Vazirmatn-Regular.woff2') format('woff2');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
```

### Font Download

To download missing fonts, run:

```bash
cd /path/to/nextpixel
python scripts/download-fonts.py
```

This script automatically downloads all Vazirmatn variants from CDN and places them in `/assets/fonts/`.

## CSS Sections

### 1. Font Faces & Typography (Lines 7-48)
Vazirmatn font declarations for all weights

### 2. Base Styles (Lines 50-82)
- CSS root variables
- Global element resets
- Body styling

### 3. Keyframe Animations (Lines 84-356)
All animation definitions with `np-` prefix

### 4. Header & Navigation (Lines 358-408)
Sticky header with glass effect and scroll behavior

### 5. Glass Effect Components (Lines 410-433)
Reusable glass morphism styles

### 6. Gradient & Text Styles (Lines 435-462)
Gradient text, animated gradients, text reveals

### 7. Buttons & Interactions (Lines 464-485)
CTA buttons, magnetic hover effects

### 8. Service Cards (Lines 487-539)
Service card styles with 3D effects

### 9. Portfolio & Filters (Lines 541-570)
Portfolio grid and filter button styles

### 10. Chat Bubbles (Lines 572-600)
Chat interface styling

### 11. Preloader (Lines 602-636)
Video preloader and progress bar styling

### 12-18. Additional Sections
Floating animations, 3D hero effects, rotating borders, particles, utilities, responsive adjustments

## Usage in PHP Files

### Include Global CSS

In the `<head>` section of each PHP file:

```html
<link rel="stylesheet" href="/assets/css/nextpixel-global.css">
```

### Remove Inline Styles

Delete all `<style>` tags containing NextPixel-specific CSS. Keep only:
- Third-party library styles (AOS, etc.)
- Page-specific overrides (if necessary)

### Example Header

```html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Title</title>
    
    <!-- NextPixel Global Stylesheet -->
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    
    <!-- Third-party Styles -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Tailwind for utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
```

## Tailwind CSS Integration

Tailwind CSS is kept as a CDN import for utility classes (spacing, sizing, responsive helpers). This doesn't conflict with the NextPixel global CSS.

## Third-Party Libraries

### Kept as CDN (JavaScript)
- AOS (Animate On Scroll) - intersection animations
- Feather Icons - icon library
- ScrollReveal - scroll animations
- Three.js - 3D graphics
- Vanta.js - animated backgrounds
- Anime.js - animation library
- Lottie Player - animation player

### Kept as CDN (CSS)
- AOS CSS - animation styles
- Tailwind CSS - utility classes

### Localized (CSS & Fonts)
- Vazirmatn fonts - now self-hosted in `/assets/fonts/`
- All NextPixel component styles - now in `nextpixel-global.css`

## Performance Benefits

1. **Reduced HTTP Requests** - No external CSS CDN calls for styling
2. **Faster Font Loading** - Self-hosted fonts with `font-display: swap`
3. **Offline Support** - Styles work without internet connection
4. **Better Caching** - Local CSS can be cached by browser
5. **Single Stylesheet** - All component styles in one file for parsing efficiency
6. **Consistent Styling** - Centralized definitions ensure consistency across all pages

## Updating Styles

### Global Changes
Edit `/assets/css/nextpixel-global.css` and changes apply everywhere.

### Component-Specific Overrides
Add page-specific `<style>` tags after the global CSS link if needed:

```html
<link rel="stylesheet" href="/assets/css/nextpixel-global.css">
<style>
    /* Page-specific overrides */
    .np-service-card { /* custom styles */ }
</style>
```

### Adding New Components
1. Create CSS rules in `nextpixel-global.css`
2. Use the `np-` prefix for all classes
3. Add corresponding animations if needed
4. Update this documentation

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

CSS features used:
- CSS Custom Properties (CSS Variables)
- CSS Grid & Flexbox
- CSS Backdrop Filter
- CSS Masks
- CSS Transforms & Animations
- Gradient backgrounds

## Troubleshooting

### Fonts Not Loading

1. Verify fonts exist in `/assets/fonts/`
2. Check file permissions (readable by web server)
3. Ensure paths in CSS use `/assets/fonts/` not relative paths
4. Clear browser cache

### Styles Not Applying

1. Verify CSS file path in HTML (use `/assets/css/nextpixel-global.css`)
2. Check browser console for 404 errors
3. Ensure global CSS is included BEFORE page-specific styles
4. Clear cache: Ctrl+Shift+R (Cmd+Shift+R on Mac)

### Animation Issues

1. Check keyframe names match class animations
2. Verify `@media` queries for device-specific rules
3. Test in different browsers (Safari may need `-webkit-` prefixes)

## Maintenance Checklist

- [ ] All fonts downloaded and in `/assets/fonts/`
- [ ] Global CSS linked in all PHP files
- [ ] No inline `<style>` blocks for NextPixel components
- [ ] No duplicate class definitions
- [ ] All animations prefixed with `np-`
- [ ] CSS variables used instead of hardcoded colors
- [ ] Backward compatibility aliases present
- [ ] Documentation updated with any new sections

## Future Improvements

1. Minify CSS for production (`nextpixel-global.min.css`)
2. Split CSS into smaller modules (header, cards, animations)
3. Add CSS preprocessor (SCSS/LESS) for variables and nesting
4. Create CSS component library documentation
5. Implement CSS critical path extraction
6. Add CSS linting (StyleLint)
7. Create Tailwind config to extend with NextPixel colors

---

**Last Updated:** January 31, 2026  
**Version:** 1.0  
**Namespace Prefix:** `np-`
