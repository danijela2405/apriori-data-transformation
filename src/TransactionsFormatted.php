<?php

/**
 * Class TransactionsFormatted
 */
class TransactionsFormatted
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var integer
     */
    protected $transactionId;

    /**
     * @var array
     */
    protected $alarms;

    /**
     * @var int
     */
    protected $alarmCount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param $alarms
     */
    public function setAlarms($alarms)
    {
        $this->alarms = $alarms;
    }

    /**
     * @param $alarm
     */
    public function addAlarm($alarm)
    {
        $this->alarms[] = $alarm;
        $this->alarms = array_unique($this->alarms);
    }

    /**
     * @return array
     */
    public function getAlarms()
    {
        return $this->alarms;
    }

    /**
     * @param $alarmCount
     */
    public function setAlarmCount($alarmCount)
    {
        $this->alarmCount = $alarmCount;
    }

    /**
     * @return int
     */
    public function getAlarmCount()
    {
        return $this->alarmCount ?? 0;
    }
}