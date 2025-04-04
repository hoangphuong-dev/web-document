<?php

namespace App\Services\Document\Image;

use Exception;
use Gumlet\ImageResize;
use Illuminate\Support\Facades\Storage;

class Resize
{
    /**
     * Method make
     *
     * @param string $original
     * @param string $file_name
     * @param int $type
     *
    // $image->resize(72, 93); // small
    // $image->resize(155, 200); // medium
    // $image->resize(288, 380); /// large
     */
    public static function make(string $original, string $file_name, string $type = null): string
    {
        $thumbnailDisk = Storage::disk('thumbnail');
        try {
            $image = new ImageResize($original);
            match ($type) {
                'S'     => $image->resize(72, 93),
                'M'     => $image->resize(155, 200),
                'L'     => $image->resize(288, 380),
                default => static::allSize($original, $file_name),
            };
            $fileNew = !empty($type) ? "{$type}_{$file_name}" : $file_name;
            $image->save($resize = $thumbnailDisk->path($fileNew));
            return $resize;
        } catch (Exception $ex) {
            dump($ex->getMessage());
        }
        return $original;
    }

    private static function allSize(string $original, string $file_name): void
    {
        // static::make($original, $file_name, 'S');
        static::make($original, $file_name, 'M');
        static::make($original, $file_name, 'L');
    }
}
