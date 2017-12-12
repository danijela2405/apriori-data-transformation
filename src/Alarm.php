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
     * @var array
     */
    protected $transactions;

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
     * @param $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @param $transactionId
     */
    public function addTransaction($transactionId)
    {
        $this->transactions[] = $transactionId;
        $this->transactions = array_unique($this->transactions);
    }

    /**
     * @return array
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param $logicCameraId
     */
    public function setLogicCameraId($logicCameraId)
    {
        $this->transactions = $logicCameraId;
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