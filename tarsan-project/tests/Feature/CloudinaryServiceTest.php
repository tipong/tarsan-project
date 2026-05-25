<?php

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

test('it can extract public ID from various Cloudinary URLs', function () {
    $service = new CloudinaryService();
    
    // Use reflection to access private/protected method
    $reflection = new ReflectionClass(CloudinaryService::class);
    $method = $reflection->getMethod('extractPublicId');
    $method->setAccessible(true);

    $url1 = 'https://res.cloudinary.com/demo/image/upload/v1570590834/sample.jpg';
    expect($method->invokeArgs($service, [$url1]))->toBe('sample');

    $url2 = 'https://res.cloudinary.com/demo/image/upload/sample.png';
    expect($method->invokeArgs($service, [$url2]))->toBe('sample');

    $url3 = 'https://res.cloudinary.com/demo/image/upload/v1/folder/subfolder/image.jpg';
    expect($method->invokeArgs($service, [$url3]))->toBe('folder/subfolder/image');

    $urlInvalid = 'https://google.com/image.jpg';
    expect($method->invokeArgs($service, [$urlInvalid]))->toBeNull();
});

test('it falls back to local storage when credentials are empty', function () {
    // Clear credentials
    Config::set('services.cloudinary.cloud_name', '');
    Config::set('services.cloudinary.api_key', '');
    Config::set('services.cloudinary.api_secret', '');

    Storage::fake('public');

    $service = new CloudinaryService();
    $file = UploadedFile::fake()->image('avatar.jpg');

    $result = $service->upload($file, 'test-photos');

    // Should return a local asset URL
    expect($result)->toContain('storage/test-photos/');
    
    // File should exist on public disk
    $path = str_replace(asset('storage') . '/', '', $result);
    Storage::disk('public')->assertExists($path);
});

test('it deletes local storage files if the URL points to local storage', function () {
    Storage::fake('public');
    
    $filePath = 'profile-photos/avatar.jpg';
    Storage::disk('public')->put($filePath, 'fake content');
    Storage::disk('public')->assertExists($filePath);

    $service = new CloudinaryService();
    
    // Relative URL/path
    $result = $service->delete($filePath);
    expect($result)->toBeTrue();
    Storage::disk('public')->assertMissing($filePath);

    // Absolute local asset URL
    Storage::disk('public')->put($filePath, 'fake content');
    $absoluteUrl = asset('storage/' . $filePath);
    
    $result2 = $service->delete($absoluteUrl);
    expect($result2)->toBeTrue();
    Storage::disk('public')->assertMissing($filePath);
});

test('it can parse full cloudinary:// URL if passed to cloud_name or other fields', function () {
    Config::set('services.cloudinary.cloud_name', 'cloudinary://398252123813563:MjOXYziFcL_HiWq4K1C6-n-o2cc@dbhuchaei');
    Config::set('services.cloudinary.api_key', '');
    Config::set('services.cloudinary.api_secret', '');

    $service = new CloudinaryService();
    
    $reflection = new ReflectionClass(CloudinaryService::class);
    
    $cloudNameProp = $reflection->getProperty('cloudName');
    $cloudNameProp->setAccessible(true);
    expect($cloudNameProp->getValue($service))->toBe('dbhuchaei');

    $apiKeyProp = $reflection->getProperty('apiKey');
    $apiKeyProp->setAccessible(true);
    expect($apiKeyProp->getValue($service))->toBe('398252123813563');

    $apiSecretProp = $reflection->getProperty('apiSecret');
    $apiSecretProp->setAccessible(true);
    expect($apiSecretProp->getValue($service))->toBe('MjOXYziFcL_HiWq4K1C6-n-o2cc');
});

