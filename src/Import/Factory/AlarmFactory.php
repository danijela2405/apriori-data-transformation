<?php

namespace Import\Factory;

use Alarm;

/**
 * Class AlarmFactory
 * @package Import\Factory
 */
class AlarmFactory
{
    /**
     * @param array $alarmArray
     * @return Alarm
     */
    public static function saveAlarm(array $alarmArray)
    {
        $newAlarm = new Alarm();;
        $newAlarm->setDate($alarmArray[0]);
        $newAlarm->setTime($alarmArray[1]);
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