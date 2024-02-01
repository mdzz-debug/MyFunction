<?php

namespace mdzz\MF;

class File
{
    /**
     * save file by $_FILES
     * @param array $file $_FILES
     * @param string $path save path
     * @param string $filename save filename
     * @param string $suffix save suffix
     */
    public static function saveFile($file, $path = '', $filename = '', $suffix = '')
    {
        if (empty($file) || is_string($file) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }
        $path = rtrim(empty($path) ? './' : $path, '/') . '/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $suffix = strtolower(empty($suffix) ? pathinfo($file['name'], PATHINFO_EXTENSION) : trim($suffix));
        $filename = (empty($filename) ? pathinfo($file['name'], PATHINFO_FILENAME) : $filename) . '.' . $suffix;

        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            return $path . $filename;
        }

        return false;
    }

    /**
     * compress the picture
     * @param string $img image path
     * @param int $max_width max width
     * @param int $max_height max height
     * @param int $quality quality
     */
    public static function compressImage($img, $max_width = 0, $max_height = 0, $quality = 90)
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