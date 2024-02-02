<?php

namespace mdzz\MF;

use mdzz\MF\package\BaseMf;

require_once __DIR__ . '/package/phpqrcode.php';

class Qr extends BaseMf
{

    private $img; // image source

    private $path; // image save path

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
            if (!$path) {
                return false;
            }
            \QRcode::png($text, $path, $level, $size, $margin, true);
            return $path;
        } else {
            \QRcode::png($text, false, $level, $size, $margin);
            exit();
        }
    }

    /**
     * Turn string to QR code
     * @param string $content QR code content
     * @param string|bool $level QR code error correction level (0-3), default 3
     * @param string|bool $size QR code size, default 10
     * @param string|bool $margin QR code margin, default 1
     * @return Qr
     */
    public function createQr($content, $level = 3, $size = 10, $margin = 1)
    {
        ob_start();
        \QRcode::png($content, false, $level, $size, $margin);
        $this->img = ob_get_contents();
        ob_end_clean();

        return $this;
    }

    /**
     * Save QR code with logo to file
     * @param $path string
     * @return $this
     */
    public function logo($path)
    {
        if ($path && file_exists($path)) {
            $logo = imagecreatefromstring(file_get_contents($path));
            $qr = imagecreatefromstring($this->img);
            $qrWidth = imagesx($qr);
            $qrHeight = imagesy($qr);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);
            $logoQrWidth = $qrWidth / 5;
            $scale = $logoWidth / $logoQrWidth;
            $logoQrHeight = $logoHeight / $scale;
            $fromWidth = ($qrWidth - $logoQrWidth) / 2;
            imagecopyresampled($qr, $logo, $fromWidth, $fromWidth, 0, 0, $logoQrWidth, $logoQrHeight, $logoWidth, $logoHeight);

            ob_start();
            imagepng($qr);
            $this->img = ob_get_contents();
            ob_end_clean();
        }

        return $this;
    }

    /**
     * save QR code to path
     * @param $path string
     * @return bool|string
     */
    public function save($path, $filename = '')
    {
        $this->path = self::checkPath($path.$filename);
        if (!$this->path) {
            return false;
        }
        file_put_contents($this->path, $this->img);
        return $this->path;
    }

    /**
     * @param bool $base64 default true
     * @return string
     */
    public function base64($base64 = true)
    {
        if (!$base64) {
            return $this->img;
        }
        return 'data:image/png;base64,' . base64_encode($this->img);
    }

}