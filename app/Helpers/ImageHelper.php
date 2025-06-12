<?php

namespace App\Helpers;

class ImageHelper
{
    public static function convertToAvif(string $sourcePath, string $targetFolder = 'uploads', int $quality = 60): string
    {
        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $name = pathinfo($sourcePath, PATHINFO_FILENAME);
        $sourceFull = public_path($sourcePath);

        $gd = match ($ext) {
            'jpg', 'jpeg' => imagecreatefromjpeg($sourceFull),
            'png' => imagecreatefrompng($sourceFull),
            'webp' => imagecreatefromwebp($sourceFull),
            default => throw new \Exception("Unsupported format: $ext"),
        };

        if (!function_exists('imageavif')) {
            throw new \Exception("Your PHP GD library does not support AVIF.");
        }

        $avifPath = "$targetFolder/{$name}.avif";
        $avifFull = public_path($avifPath);

        if (!file_exists(dirname($avifFull))) {
            mkdir(dirname($avifFull), 0755, true);
        }

        imageavif($gd, $avifFull, $quality);
        imagedestroy($gd);
        
        // ✅ Delete the original file
        if (file_exists($sourceFull)) {
            unlink($sourceFull);
        }

        return $avifPath;
    }
}
