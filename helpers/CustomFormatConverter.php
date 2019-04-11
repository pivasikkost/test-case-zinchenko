<?php

namespace app\helpers;

/**
 * CustomFormatConverter provides functionality to convert between different formatting pattern formats.
 *
 * It provides functions to convert date format patterns between different conventions.
 *
 * @author Konstantin Zosimenko <pivasikkost@gmail.com>
 * @since 1.0
 */
class CustomFormatConverter
{
    const DATE_FORMAT = "Y-m-d";
    const TIME_FORMAT = "H:i:s";

    /**
     * @param int $timestamp
     * @return string
     */
    public static function getDateText($timestamp)
    {
        return gmdate(static::DATE_FORMAT, $timestamp);
    }

    /**
     * @param int $timestamp
     * @return string
     */
    public static function getTimeText($timestamp)
    {
        return gmdate(static::TIME_FORMAT, $timestamp);
    }
}