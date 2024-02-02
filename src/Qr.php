<?php

namespace mdzz\MF;

use mdzz\MF\package\BaseMf;

require_once __DIR__ . '/package/phpqrcode.php';

class Qr extends BaseMf
{
    /**
     * Turn string to QR code
     * @param string $text QR code content
     * @param string|bool $path QR code save path, default false
     * @param string|bool $level QR code error correction level (0-3), default 3
     * @param string|bool $size QR code size, default 10
     * @param string|bool $margin QR code margin, default 1
     * @return string|bool
     */
    public static function createQRCode($text, $path = false, $level = 3, $size = 10, $margin = 1)
    {
        if ($path) {
            $path = self::checkPath($path);
            if (!$path){
                return false;
            }
            \QRcode::png($text, $path, $level, $size, $margin, true);
            return $path;
        } else {
            \QRcode::png($text, false, $level, $size, $margin);
            exit();
        }
    }
}