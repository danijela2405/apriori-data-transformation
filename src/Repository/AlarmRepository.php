<?php

namespace Repository;

use Alarm;
use Doctrine\ORM\EntityRepository;
use Import\Helper\DateTimeHelper;

/**
 * Class AlarmRepository
 * @package Repository
 */
class AlarmRepository extends EntityRepository
{
    public function persistAlarm($alarm)
    {
        $this->_em->persist($alarm);
        $this->_em->detach($alarm);
    }

    public function flush()
    {
        $this->_em->flush();
        $this->_em->clear();
    }

    /**
     * @param string $file
     * @param array $parameters
     */
    public function importCsv($file = 'alarms.csv', array $parameters)
    {
        $pdoConn = $this->buildPDOConnection($parameters);

        $sql =
            'LOAD DATA local INFILE "'.$file.'"
        INTO TABLE alarm
        FIELDS TERMINATED by \',\'
        LINES TERMINATED BY \'\n\'';

        $query = $pdoConn->prepare($sql);
        $query->execute();

        return;
    }

    public function findTimePeriods()
    {
        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->select("DATE_FORMAT(a.date,'%Y-%m-%d') as day")
            ->distinct(true)
            ->groupBy("day");

        return $query->getQuery()->getResult();
    }

    public function findTransactionByDate($date)
    {
        $qb = $this->createQueryBuilder('a');
        $query =
            $qb
                ->select("a")
                ->where("DATE_FORMAT(a.date, '%Y-%m-%d') = :date")
                ->setParameter("date", $date)
                ->orderBy("a.time");

        return $query->getQuery()->getResult();
    }

    public function findTransactionByDateAndInterval(Alarm $alarm, $dailyAlarms)
    {
        $time = $alarm->getTime();
        $qb = $this->createQueryBuilder('a');
        $query =
            $qb
                ->select("a")
                ->where('a.id IN (:dailyAlarms)')
                ->andWhere(
                    "ABS((:minutes - (DATE_FORMAT(a.time, '%i'))) + (:hours - (DATE_FORMAT(a.time, '%H')))*60)  <= :minutesInTransaction"
                )
                ->setParameter('dailyAlarms', $dailyAlarms)
                ->setParameter("hours", $time->format('H'))
                ->setParameter("minutes", $time->format('i'))
                ->setParameter("minutesInTransaction", DateTimeHelper::$minutesInTransaction)
                ->orderBy('a.time');

        return $query->getQuery()->getResult();
    }

    /**
     * @param array $parameters
     * @return \PDO
     */
    private
    function buildPDOConnection(
        array $parameters
    ) {
        $pdoConn = new \PDO(
            'mysql:host='.$parameters['host'].';dbname='.$parameters['dbname'],
            $parameters['user'],
            $parameters['password'],
            array(
                \PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            )
        );

        $sql = "SET FOREIGN_KEY_CHECKS=0";
        $stmt = $pdoConn->prepare($sql);
        $stmt->execute();

        return $pdoConn;

    }
}