#!/usr/bin/env python3
"""
NextPixel Font Downloader
Downloads Vazirmatn font variants from CDN and saves them locally
"""

import urllib.request
import os
import sys

def download_font(url, filename, output_dir):
    """Download a font file from CDN"""
    try:
        output_path = os.path.join(output_dir, filename)
        print(f"Downloading {filename}...")
        urllib.request.urlretrieve(url, output_path)
        print(f"✓ Saved: {output_path}")
        return True
    except Exception as e:
        print(f"✗ Error downloading {filename}: {e}")
        return False

def main():
    # Font variants to download
    fonts = {
        'Vazirmatn-Regular.woff2': 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Regular.woff2',
        'Vazirmatn-Bold.woff2': 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Bold.woff2',
        'Vazirmatn-ExtraBold.woff2': 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-ExtraBold.woff2',
        'Vazirmatn-Black.woff2': 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Black.woff2',
    }
    
    # Output directory
    output_dir = os.path.join(os.path.dirname(__file__), 'assets', 'fonts')
    
    # Create directory if it doesn't exist
    os.makedirs(output_dir, exist_ok=True)
    
    print(f"NextPixel Font Downloader")
    print(f"Output directory: {output_dir}\n")
    
    success_count = 0
    for filename, url in fonts.items():
        if download_font(url, filename, output_dir):
            success_count += 1
    
    print(f"\n✓ Successfully downloaded {success_count}/{len(fonts)} fonts")
    print("\nNote: Make sure all fonts are properly saved before using the website.")

if __name__ == '__main__':
    main()
