<?php

/**
 * Manipula Imagenes Facilamente
 */
class ImageConverter
{
    public function loadImage(string $path)
    {

    }

    public function resize()
    {

    }

    public function convert()
    {

    }

    public function fill()
    {

    }

    public function convertWebp($path, $quality = 70, bool $transparency = false)
    {
        exec('cwebp -q '.$quality.' '.$path . ($transparency?'.png':'.jpg') . ' -o '.$path.'.webp');
    }

    public static function removeImage($folder, $file, $extension, $rm_original)
    {
        $folder = public_path('storage/' . $folder);
        $files  = scandir($folder);

        if ($rm_original) {
            unlink($folder . $file . '.' . $extension);
        }

        foreach ($files as $image) {
            if (strpos($image, $file . '-') === 0) {
                unlink($folder . $image);
            }
        }
    }
}
