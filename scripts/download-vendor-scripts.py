#!/usr/bin/env python3
"""
Download all CDN scripts to local vendor directory
"""

import os
import urllib.request
import sys

# Create vendor directories if they don't exist
vendor_js_dir = r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor'
vendor_css_dir = r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\css\vendor'

os.makedirs(vendor_js_dir, exist_ok=True)
os.makedirs(vendor_css_dir, exist_ok=True)

# List of scripts to download
scripts = {
    # JavaScript files
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\tailwind.min.js': 'https://cdn.tailwindcss.com',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\aos.min.js': 'https://unpkg.com/aos@2.3.1/dist/aos.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\feather.min.js': 'https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\scrollreveal.min.js': 'https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\lottie-player.min.js': 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\three.min.js': 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\vanta.globe.min.js': 'https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\vanta.waves.min.js': 'https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js',
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\js\vendor\anime.min.js': 'https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js',
    
    # CSS files
    r'c:\Users\Hojat\OneDrive\Desktop\NeXTPixel\assets\css\vendor\aos.min.css': 'https://unpkg.com/aos@2.3.1/dist/aos.css',
}

downloaded = 0
failed = []

for file_path, url in scripts.items():
    try:
        print(f"Downloading: {url}")
        urllib.request.urlretrieve(url, file_path)
        file_size = os.path.getsize(file_path) / 1024  # Size in KB
        print(f"  ✓ Saved: {os.path.basename(file_path)} ({file_size:.1f} KB)")
        downloaded += 1
    except Exception as e:
        print(f"  ✗ Failed: {str(e)}")
        failed.append((os.path.basename(file_path), str(e)))

print(f"\n{'='*50}")
print(f"Downloaded: {downloaded}/{len(scripts)} files")
if failed:
    print(f"\nFailed downloads:")
    for name, error in failed:
        print(f"  - {name}: {error}")
else:
    print("All scripts downloaded successfully!")
