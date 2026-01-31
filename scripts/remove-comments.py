#!/usr/bin/env python3
import os
import re
import glob

print("NextPixel Comment Remover")
print("=" * 60)

def remove_html_comments(content):
    """Remove HTML comments <!-- ... -->"""
    content = re.sub(r'<!--.*?-->', '', content, flags=re.DOTALL)
    return content

def remove_js_comments(content):
    """Remove JavaScript-style comments // and /* */"""
    lines = content.split('\n')
    result = []
    in_block_comment = False
    
    for line in lines:
        if in_block_comment:
            if '*/' in line:
                in_block_comment = False
                line = line.split('*/', 1)[1] if '*/' in line else ''
            else:
                continue
        
        if '/*' in line and not in_block_comment:
            if '*/' in line:
                before = line.split('/*')[0]
                after = line.split('*/', 1)[1] if '*/' in line else ''
                line = before + after
            else:
                in_block_comment = True
                line = line.split('/*')[0]
        
        if not in_block_comment and '//' in line:
            parts = line.split('//')
            code_part = parts[0]
            comment_part = '//' + '//'.join(parts[1:])
            if "'" not in code_part and '"' not in code_part:
                line = code_part
        
        result.append(line)
    
    return '\n'.join(result)

def remove_php_comments(content):
    """Remove PHP-style comments // and /* */"""
    lines = content.split('\n')
    result = []
    in_block_comment = False
    
    for line in lines:
        original_line = line
        if in_block_comment:
            if '*/' in line:
                in_block_comment = False
                line = line.split('*/', 1)[1] if '*/' in line else ''
            else:
                line = ''
        
        if '/*' in line and not in_block_comment:
            if '*/' in line:
                before = line.split('/*')[0]
                after = line.split('*/', 1)[1] if '*/' in line else ''
                line = before + after
            else:
                in_block_comment = True
                line = line.split('/*')[0]
        
        if not in_block_comment and not line.strip().startswith('//'):
            if '//' in line:
                in_string = False
                quote_char = None
                i = 0
                while i < len(line):
                    if line[i] in ('"', "'") and (i == 0 or line[i-1] != '\\'):
                        if not in_string:
                            in_string = True
                            quote_char = line[i]
                        elif line[i] == quote_char:
                            in_string = False
                    elif line[i:i+2] == '//' and not in_string:
                        line = line[:i]
                        break
                    i += 1
        
        if line.strip() or line.strip() == '':
            result.append(line)
    
    return '\n'.join(result)

def clean_file(filepath):
    """Remove comments from a PHP file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_size = len(content)
        
        content = remove_html_comments(content)
        content = remove_js_comments(content)
        content = remove_php_comments(content)
        
        content = re.sub(r'\n\s*\n\s*\n+', '\n\n', content)
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        
        final_size = len(content)
        reduction = original_size - final_size
        
        return True, reduction
    except Exception as e:
        return False, str(e)

base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

php_files = [
    os.path.join(base_dir, 'index.php'),
    os.path.join(base_dir, 'services.php'),
    os.path.join(base_dir, 'portfolio.php'),
    os.path.join(base_dir, 'contact.php'),
    os.path.join(base_dir, 'about.php'),
    os.path.join(base_dir, 'login.php'),
    os.path.join(base_dir, 'n8n-admin.php'),
    os.path.join(base_dir, 'auth.php'),
    os.path.join(base_dir, 'chat-proxy.php'),
    os.path.join(base_dir, 'config.php'),
]

php_files += glob.glob(os.path.join(base_dir, 'api', '*.php'))
php_files += glob.glob(os.path.join(base_dir, 'panel', '**', '*.php'), recursive=True)

total_reduction = 0
success_count = 0
failed_count = 0

for filepath in php_files:
    if os.path.exists(filepath):
        success, result = clean_file(filepath)
        if success:
            print(f"✓ {os.path.relpath(filepath, base_dir):<50} ({result:>6} bytes removed)")
            total_reduction += result
            success_count += 1
        else:
            print(f"✗ {os.path.relpath(filepath, base_dir):<50} Error: {result}")
            failed_count += 1

print("=" * 60)
print(f"Processed: {success_count} files successfully")
if failed_count > 0:
    print(f"Failed: {failed_count} files")
print(f"Total size reduction: {total_reduction:,} bytes")
print("✓ Comment removal complete!")
