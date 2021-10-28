<?php
namespace Sdkconsultoria\Base\Helpers;

use Image;
use Sdkconsultoria\Base\Models\Common\Image\ImageSize;

class Images
{
    public static function convertImage(string $folder, string $file, string $extension, array $config = []) : void
    {
        if (!$config) {
            $config = $value = config('base.images.sizes');
        }

        foreach ($config as $row) {
            $fill = $row['fill'] ?? false;
            $aspect = $row['aspect'] ?? '';

            $img = Image::make(public_path('storage/'.$folder.$file.'.'.$extension));



            if ($aspect == 'crop') {
                $img->fit($row['width'],  $row['height'], function ($constraint) {
                    $constraint->upsize();
                });
            } else {
                $img->resize($row['width'], $row['height'], function ($constraint) use ($aspect) {
                    switch ($aspect) {
                        case 'upsize':
                        case 'crop':
                            $constraint->upsize();
                            break;
                        case 'all':
                            $constraint->aspectRatio();
                            $constraint->upsize();
                            break;
                        case 'aspectRatio':
                            $constraint->aspectRatio();
                            break;
                        default:
                            break;
                    }
                });
            }

            $img = self::fill($fill, $img);
            $img->save(public_path('storage/'.$folder.$file.'-'. $row['name'] . ($fill ? '.jpg':'.png')));
            Images::convertImageWebp(public_path('storage/'.$folder.$file.'-'. $row['name']), 100, !$fill);

            if (!$fill) {
                rename(public_path('storage/'.$folder.$file.'-'. $row['name'] . '.png'), public_path('storage/'.$folder.$file.'-'. $row['name'] .'.jpg'));
            }
        }
    }

    public static function convertImageWebp($path, $quality = 70, bool $transparency = false)
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

    protected static function fill($fill, $img)
    {
        if ($fill) {
            $new_img = Image::canvas($img->width(), $img->height(), $fill);
            $new_img->insert($img);

            return $new_img;
        }

        return $img;
    }
}
