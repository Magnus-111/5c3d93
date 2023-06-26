<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 26.06.2023
 * @license MIT
 */

namespace Helpers;

class ValidationHelper
{
    /**
     * Validate if string is date.
     *
     * @param string|null $date
     * @return bool
     */
    public static function isValidDate(?string $date): bool
    {
        if (empty($date)) {
            return false;
        }

        return (strtotime($date) !== false);
    }
}