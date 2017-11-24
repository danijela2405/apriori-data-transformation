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
     * @param $time
     * @param $date
     * @param $idCamera
     * @param $cameraPosition
     * @param $idLogicCamera
     * @param $presetName
     * @return Alarm
     */
    public static function setAlarmEntity(
        $time,
        $date,
        $idCamera,
        $cameraPosition,
        $idLogicCamera,
        $presetName
    ) {

        $alarm = new Alarm();

        $alarm->setTimestamp(DateTimeHelper::prepareDateTime($date, $time));
        $alarm->setCameraId($idCamera);
        $alarm->setCameraPosition($cameraPosition);
        $alarm->setLogicCameraId($idLogicCamera);
        $alarm->setPresetName($presetName);

        return $alarm;
    }
}