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
    protected $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

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
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
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