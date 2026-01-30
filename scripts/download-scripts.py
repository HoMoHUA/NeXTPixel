#!/usr/bin/env python3
import os
import urllib.request
import urllib.error

print("NextPixel CDN Scripts Downloader")
print("=" * 50)

base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
scripts_dir = os.path.join(base_dir, "assets", "js", "vendor")
css_dir = os.path.join(base_dir, "assets", "css", "vendor")

os.makedirs(scripts_dir, exist_ok=True)
os.makedirs(css_dir, exist_ok=True)

scripts = {
    "tailwind.min.js": "https://cdn.tailwindcss.com",
    "aos.min.js": "https://unpkg.com/aos@2.3.1/dist/aos.js",
    "aos.min.css": "https://unpkg.com/aos@2.3.1/dist/aos.css",
    "feather.min.js": "https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js",
    "scrollreveal.min.js": "https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js",
    "lottie-player.min.js": "https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js",
    "three.min.js": "https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js",
    "vanta.globe.min.js": "https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js",
    "vanta.waves.min.js": "https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js",
    "anime.min.js": "https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js",
}

downloaded = 0
failed = 0

for filename, url in scripts.items():
    if filename.endswith('.css'):
        filepath = os.path.join(css_dir, filename)
    else:
        filepath = os.path.join(scripts_dir, filename)
    
    try:
        print(f"Downloading {filename}...", end=" ")
        urllib.request.urlretrieve(url, filepath)
        file_size = os.path.getsize(filepath)
        print(f"✓ ({file_size:,} bytes)")
        downloaded += 1
    except urllib.error.URLError as e:
        print(f"✗ Failed: {e}")
        failed += 1
    except Exception as e:
        print(f"✗ Error: {e}")
        failed += 1

print("=" * 50)
print(f"Downloaded: {downloaded}/{len(scripts)} files")
if failed > 0:
    print(f"Failed: {failed} files")
else:
    print("✓ All scripts downloaded successfully!")
print(f"Location: {scripts_dir}")
print(f"CSS Location: {css_dir}")
