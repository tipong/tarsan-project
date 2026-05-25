<?php

if (!function_exists('image_url')) {
    /**
     * Get the url for a given image path.
     * Supports both absolute URLs (e.g. Cloudinary) and local storage paths.
     *
     * @param string|null $path
     * @param string|null $default
     * @return string
     */
    function image_url(?string $path, ?string $default = null): string
    {
        if (!$path) {
            return $default ?? asset('images/default-avatar.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}
