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
     * @var int
     */
    protected $transactionId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
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
     * @param $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->logicCameraId = $transactionId;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param $logicCameraId
     */
    public function setLogicCameraId($logicCameraId)
    {
        $this->transactionId = $logicCameraId;
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