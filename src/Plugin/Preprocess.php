<?php

declare(strict_types=1);

namespace Johnny\ImageToolKit\Plugin;

use Johnny\ImageToolKit\Exceptions\ExifNotSupportedException;

class Preprocess
{
    private $args;

    public function __construct($args = [])
    {
        $this->args = $args;
    }

    public function correct(string $content)
    {
        $image = imagecreatefromstring($content);

        $exif        = $this->exifInfo($content);
        $ifd0        = $exif['IFD0']        ?? [];
        $orientation = $ifd0['Orientation'] ?? null;

        if ($orientation) {
            switch ($orientation) {
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, 0, 0);
                    break;
            }
        }
        $tempFile = tempnam(sys_get_temp_dir(), 'php');
        imagejpeg($image, $tempFile, 100);
        $imageContent = file_get_contents($tempFile);
        unlink($tempFile);
        imagedestroy($image);
        return $imageContent;

        // throw new ExifNotSupportedException('Unable to retrieve the EXIF information from the image');
    }

    public function exifInfo(string $content)
    {
        try {
            $tempFilePath = tempnam(sys_get_temp_dir(), 'exif');
            file_put_contents($tempFilePath, $content);
            $exif = exif_read_data($tempFilePath, '0', true);
            unlink($tempFilePath);
        } catch (\Exception $e) {
            throw new ExifNotSupportedException('Unable to retrieve the EXIF information from the image');
        }

        return $exif;
    }
}
