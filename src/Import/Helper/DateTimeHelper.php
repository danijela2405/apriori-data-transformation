<?php

namespace Import\Helper;

use DateTime;

/**
 * Class DateTimeHelper
 * @package Import\Helper
 */
class DateTimeHelper
{
    public static $minutesInTransaction = 3;

    /**
     * @param int $y
     * @param int $m
     * @param int $d
     * @param int $h
     * @param int $i
     * @param int $s
     * @return DateTime
     */
    public static function prepareDateTime(int $y = 1970, int $m = 1, int $d = 1, int $h = 0, int $i = 0, int $s = 0)
    {
        $dateTime = new DateTime();
        $dateTime->setDate($y, $m, $d);
        $dateTime->setTime($h, $i, $s);

        return $dateTime;
    }

    /**
     * @param int $timestamp
     * @return DateTime
     */
    public static function getDateTimeFromTimestamp(int $timestamp)
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);
        return $dateTime;
    }


}