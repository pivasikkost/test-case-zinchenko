<?php

namespace app\helpers;

/**
 * DbHelper provides functionality to get specific information from the database.
 *
 * @author Konstantin Zosimenko <pivasikkost@gmail.com>
 * @since 2.0
 */
class DbHelper
{
    /**
     * @param string $name
     * @param string $dsn
     *
     * @return string
     */
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}