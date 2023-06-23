<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 23.06.2023
 * @license MIT
 */

namespace Helpers;

class AnalyseHelper
{
    /**
     * @param $description
     * @param $pattern
     * @return bool
     */
    public static function define($description, $pattern): bool
    {
        preg_match_all($pattern, $description, $matches, PREG_SET_ORDER);

        return count($matches) > 0;
    }
}