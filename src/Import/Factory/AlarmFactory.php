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
        $newAlarm = clone $alarm;
        $newAlarm->setTimestamp(DateTimeHelper::prepareDateTime($alarmArray[1], $alarmArray[0]));
        $newAlarm->setCameraId($alarmArray[2]);
        $newAlarm->setCameraPosition($alarmArray[3]);
        $newAlarm->setLogicCameraId($alarmArray[4]);
        $newAlarm->setPresetName($alarmArray[5]);

        return $newAlarm;
    }

    /**
     * @return Alarm
     */
    public static function createAlarm()
    {
        return new Alarm();
    }
}