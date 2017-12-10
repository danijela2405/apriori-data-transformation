<?php
/**
 * Class Alarm
 * @package Entity
 */
class Alarm
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var
     */
    private $date;
    
    /**
     * @var 
     */
    private $time;

    /**
     * @var int
     */
    protected $cameraId;

    /**
     * @var string
     */
    protected $cameraPosition;

    /**
     * @var int
     */
    protected $logicCameraId;

    /**
     * @var string
     */
    protected $presetName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getCameraId()
    {
        return $this->cameraId;
    }

    /**
     * @param $cameraId
     */
    public function setCameraId($cameraId)
    {
        $this->cameraId = $cameraId;
    }

    /**
     * @return string
     */
    public function getCameraPosition()
    {
        return $this->cameraPosition;
    }

    /**
     * @param $cameraPosition
     */
    public function setCameraPosition($cameraPosition)
    {
        $this->cameraPosition = $cameraPosition;
    }

    /**
     * @return int
     */
    public function getLogicCameraId()
    {
        return $this->logicCameraId;
    }

    /**
     * @param $logicCameraId
     */
    public function setLogicCameraId($logicCameraId)
    {
        $this->logicCameraId = $logicCameraId;
    }

    /**
     * @return string
     */
    public function getPresetName()
    {
        return $this->presetName;
    }

    /**
     * @param $presetName
     */
    public function setPresetName($presetName)
    {
        $this->presetName = $presetName;
    }
}