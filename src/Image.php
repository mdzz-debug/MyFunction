<?php

namespace mdzz\MF;

use mdzz\MF\package\BaseMf;

class Image extends BaseMf
{
    /**
     * compress the picture
     * @param string $img image path
     * @param int $max_width max width, default 0
     * @param int $max_height max height, default 0
     * @param int $quality quality, default 75
     * @return string|bool image path
     */
    public static function compressImage($img, $max_width = 0, $max_height = 0, $quality = 75)
    {
        if (empty($img) || !file_exists($img)) {
            return false;
        }
        $info = getimagesize($img);
        if ($info === false) {
            return false;
        }
        $type = image_type_to_extension($info[2], false);
        $fun = "imagecreatefrom{$type}";
        if (!function_exists($fun)) {
            return false;
        }
        $image = $fun($img);
        if ($max_width > 0 && $max_height > 0) {
            $width = $info[0];
            $height = $info[1];
            if ($width > $max_width || $height > $max_height) {
                $ratio_width = $max_width / $width;
                $ratio_height = $max_height / $height;
                $ratio = min($ratio_width, $ratio_height);
                $new_width = (int)$width * $ratio;
                $new_height = (int)$height * $ratio;
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagedestroy($image);
                $image = $new_image;
            }
        }
        $fun = "image{$type}";
        $fun($image, $img, $quality);
        imagedestroy($image);
        return $img;
    }
}