<?php

namespace Repository;

use Alarm;
use Doctrine\ORM\EntityRepository;

/**
 * Class AlarmRepository
 * @package Repository
 */
class AlarmRepository extends BaseRepository
{
    public function findChunkByIds($startId, $endId)
    {
        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->select("a")
            ->where('a.id > :startId')
            ->andWhere('a.id <= :endId')
            ->setParameter('startId', $startId)
            ->setParameter('endId', $endId);

        return $query->getQuery()->getResult();
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
                ->setParameter("minutesInTransaction", 2)
                ->orderBy('a.time');

        return $query->getQuery()->getResult();
    }
}