<?php

namespace App\Services\Storage;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;

class DiskPathService
{
    public static function diskFile()
    {
        return Storage::disk('s3_file');
    }
    public static function document()
    {
        return Storage::disk('s3_document');
    }

    public static function sitemap()
    {
        return Storage::disk('sitemap');
    }

    public static function storeFile($filePath, $fileContent)
    {
        return static::diskFile()
            ->put($filePath, $fileContent, [
                'StorageClass' => 'STANDARD',
            ]);
    }

    public static function storePreview($fileName, $fileContent)
    {
        $path = "preview/{$fileName}";
        return static::storeFile($path, $fileContent);
    }

    public static function storeThumbnail($fileName, $fileContent)
    {
        $path = "thumbnail/{$fileName}";
        return static::storeFile($path, $fileContent);
    }

    public static function urlThumbnail(string $fileName, string $size = 'L')
    {
        $path = "thumbnail/{$size}_{$fileName}";
        if (static::diskFile()->exists($path)) {
            return static::diskFile()->url("{$path}");
        } else {
            return ImageHelper::getImageDefault('doc');
        }
    }

    public static function urlPreview(string $fileName)
    {
        $path = "preview/{$fileName}";
        if (static::diskFile()->exists($path)) {
            return static::diskFile()->url("{$path}");
        } else {
            return ImageHelper::getImageDefault('doc');
        }
    }

    public static function storeFulltext(string $path, string $fileName, $fileContent)
    {
        $path = "fulltext/{$path}/{$fileName}";
        return static::storeFile($path, $fileContent);
    }

    public static function getFulltext(string $path, string $fileName)
    {
        return static::diskFile()->get("fulltext/{$path}/{$fileName}");
    }

    public static function storeDocument($filePath, $fileContent)
    {
        return static::document()->put($filePath, $fileContent, [
            // 'StorageClass' => 'GLACIER',
            'StorageClass' => 'STANDARD',
        ]);
    }
}
