<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    protected string $cloudName;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct()
    {
        $cloudName = trim((string) config('services.cloudinary.cloud_name'));
        $apiKey = trim((string) config('services.cloudinary.api_key'));
        $apiSecret = trim((string) config('services.cloudinary.api_secret'));

        // If any of the variables contains a full cloudinary URL, parse it to extract components
        foreach ([$cloudName, $apiKey, $apiSecret] as $val) {
            if (str_starts_with($val, 'cloudinary://')) {
                $parsed = parse_url($val);
                if ($parsed) {
                    if (isset($parsed['host'])) {
                        $cloudName = $parsed['host'];
                    }
                    if (isset($parsed['user'])) {
                        $apiKey = $parsed['user'];
                    }
                    if (isset($parsed['pass'])) {
                        $apiSecret = $parsed['pass'];
                    }
                }
                break;
            }
        }

        $this->cloudName = $cloudName;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Upload a file to Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string Secure URL of the uploaded image
     * @throws \Exception
     */
    public function upload($file, string $folder = 'tarsan_homestay'): string
    {
        if (empty($this->cloudName) || empty($this->apiKey) || empty($this->apiSecret)) {
            Log::warning('Cloudinary credentials are not configured properly. Falling back to local storage.');
            // Fall back to local storage path to avoid completely breaking the application if no cloud name is provided
            $path = $file->store($folder, 'public');
            return asset('storage/' . $path);
        }

        $timestamp = time();
        $params = [
            'folder' => $folder,
            'timestamp' => $timestamp,
        ];

        ksort($params);

        $signatureStr = '';
        foreach ($params as $key => $value) {
            $signatureStr .= "$key=$value&";
        }
        $signatureStr = rtrim($signatureStr, '&') . $this->apiSecret;
        $signature = sha1($signatureStr);

        try {
            $response = Http::asMultipart()
                ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post("https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload", array_merge($params, [
                    'api_key' => $this->apiKey,
                    'signature' => $signature,
                ]));

            if ($response->successful()) {
                return $response->json('secure_url');
            }

            Log::error('Cloudinary upload request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Cloudinary Upload Failed: ' . $response->json('error.message', $response->body()));
        } catch (\Exception $e) {
            Log::error('Exception in CloudinaryService::upload: ' . $e->getMessage());
            // Safe fallback to local public storage to prevent crashing the application
            $path = $file->store($folder, 'public');
            return asset('storage/' . $path);
        }
    }

    /**
     * Delete an image from Cloudinary using its secure URL.
     *
     * @param string|null $url
     * @return bool
     */
    public function delete(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        // If it's a local storage URL, delete from local storage
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            // Local path stored in db e.g. "profile-photos/filename.jpg"
            return \Illuminate\Support\Facades\Storage::disk('public')->delete($url);
        }

        // If it contains the local app url or is a local asset URL starting with http
        $appUrl = config('app.url');
        if (str_starts_with($url, $appUrl)) {
            $localPath = str_replace($appUrl . '/storage/', '', $url);
            return \Illuminate\Support\Facades\Storage::disk('public')->delete($localPath);
        }

        // If it's not a Cloudinary URL, we can't delete it via Cloudinary API
        if (!str_contains($url, 'cloudinary.com')) {
            return false;
        }

        if (empty($this->cloudName) || empty($this->apiKey) || empty($this->apiSecret)) {
            return false;
        }

        $publicId = $this->extractPublicId($url);
        if (!$publicId) {
            return false;
        }

        $timestamp = time();
        $params = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];
        ksort($params);

        $signatureStr = '';
        foreach ($params as $key => $value) {
            $signatureStr .= "$key=$value&";
        }
        $signatureStr = rtrim($signatureStr, '&') . $this->apiSecret;
        $signature = sha1($signatureStr);

        try {
            $response = Http::asMultipart()
                ->post("https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy", array_merge($params, [
                    'api_key' => $this->apiKey,
                    'signature' => $signature,
                ]));

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Exception in CloudinaryService::delete: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extract the Cloudinary public ID from a secure URL.
     *
     * @param string $url
     * @return string|null
     */
    private function extractPublicId(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) {
            return null;
        }

        $segments = explode('/', $path);
        $uploadIndex = array_search('upload', $segments);
        if ($uploadIndex === false) {
            return null;
        }

        $startIndex = $uploadIndex + 1;
        if (isset($segments[$startIndex]) && preg_match('/^v\d+$/', $segments[$startIndex])) {
            $startIndex++;
        }

        $publicIdSegments = array_slice($segments, $startIndex);
        $publicIdWithExtension = implode('/', $publicIdSegments);

        $info = pathinfo($publicIdWithExtension);
        return $info['dirname'] === '.' ? $info['filename'] : $info['dirname'] . '/' . $info['filename'];
    }
}
