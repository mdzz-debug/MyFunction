<?php

namespace mdzz\MF\package;


class BaseMf
{

    /**
     * path check
     * @param string $path path
     * @return string|bool path
     */
    protected static function checkPath($path)
    {
        try {
            $filename = pathinfo($path, PATHINFO_BASENAME) == '.' ? '' : pathinfo($path, PATHINFO_BASENAME);
            $path = pathinfo($path, PATHINFO_DIRNAME) . '/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            return $path . $filename;
        } catch (\Exception $e) {
            return false;
        }

    }

}