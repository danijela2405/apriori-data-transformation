<?php
namespace Import\Helper;

use DateTime;

/**
 * Class DateTimeHelper
 * @package Import\Helper
 */
class DateTimeHelper
{
    /**
     * @param $date
     * @param $time
     * @return bool|DateTime
     */
    public static function prepareDateTime($date, $time)
    {
        $explodedTime = explode('.', $time);
        $alarmTimestamp = DateTime::createFromFormat('Y-m-d H:i:s', $date.' '.$explodedTime[0]);

        return $alarmTimestamp;
    }
}