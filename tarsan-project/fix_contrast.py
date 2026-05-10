import os

directories = ['resources/views/admin', 'resources/views/resepsionis', 'resources/views/tamu', 'resources/views/layouts']
blade_files = ['resources/views/welcome.blade.php']

for d in directories:
    for root, dirs, files in os.walk(d):
        for file in files:
            if file.endswith('.blade.php'):
                blade_files.append(os.path.join(root, file))

replacements = {
    'bg-slate-50': 'bg-gray-50',  # Go back to a slightly darker background if needed, or keep slate-50 and darken borders
    'border-slate-100': 'border-slate-200', # Darker border for cards
    'shadow-sm': 'shadow', # Slightly more prominent shadow so white cards on white/slate-50 bg stand out
    'text-slate-400': 'text-slate-500', # Darker text for readability
    'text-slate-300': 'text-slate-400',
    'ring-slate-100': 'ring-slate-200',
    'focus:ring-slate-900': 'focus:ring-indigo-600',
    'bg-white text-sm': 'bg-white text-slate-900 text-sm', # Ensure inputs have dark text
    'bg-white border': 'bg-white border border-slate-300 text-slate-900', # Add text color to generic borders
    'text-white': 'text-white', # No change
}

for file_path in blade_files:
    if not os.path.exists(file_path): continue
    with open(file_path, 'r') as f:
        content = f.read()
    
    new_content = content
    for old, new in replacements.items():
        new_content = new_content.replace(old, new)
        
    if new_content != content:
        with open(file_path, 'w') as f:
            f.write(new_content)
        print(f"Updated {file_path}")

print("Done.")
