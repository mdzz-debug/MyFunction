<?php

namespace mdzz\MF;

use mdzz\MF\package\BaseMf;

class File extends BaseMf
{
    /**
     * save file by $_FILES
     * @param array $file $_FILES
     * @param string $path save path
     * @param string $filename save filename
     * @param string $suffix save suffix
     * @return string|bool file path
     */
    public static function saveFile($file, $path = '', $filename = '', $suffix = '')
    {
        if (empty($file) || is_string($file) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }
        $path = self::checkPath($path);
        $suffix = strtolower(empty($suffix) ? pathinfo($file['name'], PATHINFO_EXTENSION) : trim($suffix));
        $filename = (empty($filename) ? pathinfo($file['name'], PATHINFO_FILENAME) : $filename) . '.' . $suffix;

        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            return $path . $filename;
        }

        return false;
    }

    /**
     * get file size
     * @param string $file file path or url
     * @param string $unit size unit (B, KB, MB, GB, TB, PB), default KB
     * @param string|false $compare compare string, default false, example: '<200'
     * @return false|string file size
     */
    public static function getFileSize($file, $unit = 'KB', $compare = false)
    {
        if (strpos($file, 'http') === 0) {
            $file = file_get_contents($file);
            $size = strlen($file);
        } else {
            if (is_file($file)) {
                $size = filesize($file);
            } else {
                return false;
            }
        }

        if ($size === false) {
            return false;
        }
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $i = array_search($unit, $units);
        if ($i === false) {
            return false;
        }
        $size /= 1024 ** $i;
        if (!$compare || eval("return round($size, 2) $compare;")) {
            return round($size, 2) . $unit;
        } else {
            return false;
        }
    }

}