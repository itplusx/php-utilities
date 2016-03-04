<?php
namespace ITplusX\Utility;

/**
 * Utilities for UTF-8 strings.
 *
 * The class has been called Text as String in not allowed.
 */
class UTF8
{

    /**
     * Checks whether the $string is UTF-8 encoded.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isUtf8($string)
    {
        return mb_detect_encoding($string, 'UTF8', true) === 'UTF-8';
    }

    /**
     * Checks whether the $string has a BOM.
     *
     * @param $string
     *
     * @return bool
     */
    public static function hasBom($string)
    {
        $bom = self::getBom();
        if (0 === strncmp($string, $bom, 3)) {
            return true;
        }
        return false;
    }

    /**
     * Returns the UTF-8 BOM.
     *
     * @return string
     */
    public static function getBom()
    {
        return pack("CCC", 0xef, 0xbb, 0xbf);
    }

    /**
     * Removes the UTF8 BOM.
     *
     * @param $string
     *
     * @return mixed
     */
    public static function removeBom($string)
    {
        $bom = self::getBom();
        return preg_replace("/^$bom/", '', $string);;
    }
}