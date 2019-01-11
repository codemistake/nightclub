<?php

namespace App\Core\Helper;

/**
 * Class ArrayHelper
 * @package App\Core\Helper
 */
class ArrayHelper
{
    /**
     * @param string[] $needleList
     * @param string[] $haystackList
     * @return bool
     */
    public static function hasAnyOfSubstring(array $needleList, array $haystackList): bool
    {
        foreach ($needleList as $needle) {
            foreach ($haystackList as $haystack) {
                if (mb_stripos($haystack, $needle) !== false) {
                    return true;
                }
            }
        }

        return false;
    }
}
