<?php

namespace Import\Factory;

use Alarm;
use Import\Helper\DateTimeHelper;

/**
 * Class AlarmFactory
 * @package Import\Factory
 */
class AlarmFactory
{
    /**
     * @param array $alarmArray
     * @param Alarm $alarm
     * @return Alarm
     */
    public static function saveAlarm(array $alarmArray, Alarm $alarm)
    {

        $alarm->setTimestamp(DateTimeHelper::prepareDateTime($alarmArray[1], $alarmArray[0]));
        $alarm->setCameraId($alarmArray[2]);
        $alarm->setCameraPosition($alarmArray[3]);
        $alarm->setLogicCameraId($alarmArray[4]);
        $alarm->setPresetName($alarmArray[5]);

        return $alarm;
    }

    /**
     * @return Alarm
     */
    public static function createAlarm()
    {
        return new Alarm();
    }
}