<?php


namespace App\Helpers;

class ColorHelper
{
    /**
     * Hex renk kodunu ARGB formatına dönüştür.
     *
     * @param string $hex Renk kodu (# işareti ile veya işaretsiz)
     * @param string $alpha Alfa değeri (00 - FF arası)
     * @return string ARGB formatında renk kodu
     */
    public static function hexToArgb(string $hex, string $alpha = 'FF'): string
    {
        // Başındaki # işaretini kaldır
        $hex = ltrim($hex, '#');

        // Hex kodu 3 karakter ise (örneğin #FFF), her karakteri iki kere tekrar et
        if (strlen($hex) === 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2)
                . str_repeat(substr($hex, 1, 1), 2)
                . str_repeat(substr($hex, 2, 1), 2);
        }

        // Renk kodu 6 karakter olmalı
        if (strlen($hex) !== 6) {
            throw new \InvalidArgumentException("Geçersiz hex renk kodu: $hex");
        }

        // ARGB formatını oluştur
        $argb = strtoupper($alpha . substr($hex, 4, 2) . substr($hex, 2, 2) . substr($hex, 0, 2));

        return $argb;
    }
}
