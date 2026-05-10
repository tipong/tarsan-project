import os
import re

directories = ['resources/views/admin', 'resources/views/resepsionis']
blade_files = []

for d in directories:
    for root, dirs, files in os.walk(d):
        for file in files:
            if file.endswith('.blade.php'):
                blade_files.append(os.path.join(root, file))

for file_path in blade_files:
    with open(file_path, 'r') as f:
        content = f.read()
    
    new_content = content
    
    # Tables Enhancements
    new_content = new_content.replace('<thead class="bg-slate-50">', '<thead class="bg-slate-50 border-b border-slate-100">')
    new_content = new_content.replace('<th class="p-3 text-left">', '<th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">')
    new_content = new_content.replace('<td class="p-3">', '<td class="px-6 py-4 border-b border-slate-50 text-sm">')
    new_content = new_content.replace('<td class="p-4">', '<td class="px-6 py-4 border-b border-slate-50 text-sm">')
    
    # Input / Form Enhancements
    new_content = new_content.replace('class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-slate-900"', 'class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"')
    new_content = new_content.replace('class="w-full border border-slate-300 text-slate-900 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-slate-900"', 'class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"')
    
    # Labels
    new_content = new_content.replace('text-slate-700 mb-1', 'text-slate-800 font-semibold mb-2')
    new_content = new_content.replace('text-slate-700 mb-2', 'text-slate-800 font-semibold mb-2')
    
    # Form space
    new_content = new_content.replace('<div class="space-y-4">', '<div class="space-y-6">')
    
    # Add Room Button etc.
    new_content = new_content.replace('class="bg-slate-900 text-white px-4 py-2 rounded-xl hover:bg-slate-800"', 'class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-md text-sm font-medium"')
    
    if new_content != content:
        with open(file_path, 'w') as f:
            f.write(new_content)
        print(f"Enhanced {file_path}")

print("Done.")
