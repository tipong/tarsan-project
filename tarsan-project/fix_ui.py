import os
import glob

directories = ['resources/views/admin', 'resources/views/resepsionis', 'resources/views/tamu']
blade_files = []

for d in directories:
    for root, dirs, files in os.walk(d):
        for file in files:
            if file.endswith('.blade.php'):
                blade_files.append(os.path.join(root, file))

replacements = {
    'bg-gray-100': 'bg-slate-50',
    'bg-gray-200': 'bg-slate-100',
    'bg-gray-50': 'bg-slate-50',
    'border-gray-200': 'border-slate-100',
    'border-gray-300': 'border-slate-200',
    'text-gray-900': 'text-slate-900',
    'text-gray-800': 'text-slate-800',
    'text-gray-700': 'text-slate-700',
    'text-gray-600': 'text-slate-600',
    'text-gray-500': 'text-slate-500',
    'text-gray-400': 'text-slate-400',
    'rounded-lg': 'rounded-2xl',
    'rounded-md': 'rounded-xl',
    'rounded ': 'rounded-xl ',
    'bg-blue-600': 'bg-slate-900',
    'hover:bg-blue-700': 'hover:bg-slate-800',
    'text-blue-600': 'text-indigo-600',
    'bg-blue-500': 'bg-indigo-500',
    'bg-blue-50': 'bg-indigo-50',
    'ring-blue-500': 'ring-slate-900',
    'focus:ring-blue-500': 'focus:ring-slate-900',
    'focus:border-blue-500': 'focus:border-slate-900',
}

for file_path in blade_files:
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
