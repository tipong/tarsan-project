import os
import re

directories = ['resources/views/admin', 'resources/views/resepsionis']
blade_files = []

for d in directories:
    for root, dirs, files in os.walk(d):
        for file in files:
            if file.endswith('.blade.php'):
                blade_files.append(os.path.join(root, file))

# Regex patterns to find standard form inputs and table rows that might have been missed
input_pattern = re.compile(r'class="[^"]*border[^"]*rounded[^"]*px-\d[^"]*py-\d[^"]*"')
tr_pattern = re.compile(r'<tr class="[^"]*hover:bg-gray-50[^"]*">')
bg_gray_pattern = re.compile(r'bg-gray-50')

for file_path in blade_files:
    with open(file_path, 'r') as f:
        content = f.read()
    
    new_content = content
    
    # Tables enhancements
    new_content = re.sub(tr_pattern, '<tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">', new_content)
    new_content = re.sub(bg_gray_pattern, 'bg-slate-50', new_content)
    
    # Form Input styling: find all standard border inputs and replace them
    # Note: we need to be careful not to replace button classes or non-input borders.
    # It's safer to just replace 'border rounded-xl px-3 py-2' directly since it's the most common leftover.
    new_content = new_content.replace('border rounded-xl px-3 py-2', 'border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800')
    new_content = new_content.replace('border rounded px-3 py-2', 'border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800')
    
    # Generic buttons
    new_content = new_content.replace('bg-slate-900 text-white px-6 py-2 rounded', 'bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm font-medium')
    new_content = new_content.replace('px-4 py-2 border rounded', 'px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700')
    
    # Badges
    new_content = new_content.replace('bg-green-100 text-green-700 p-3 rounded', 'bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm')
    
    if new_content != content:
        with open(file_path, 'w') as f:
            f.write(new_content)
        print(f"Enhanced {file_path}")

print("Done.")
