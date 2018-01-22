<?php

namespace Repository;

/**
 * Class TransactionsFormattedRepository
 * @package Repository
 */
class TransactionsFormattedRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function findMaxAlarmsInTransaction()
    {
        $qb = $this->createQueryBuilder('t');
        $query = $qb
            ->select("t.alarmCount")
            ->orderBy('t.alarmCount', 'desc')
            ->setMaxResults(1);

        $result = $query->getQuery()->getResult();

        return $result[0]['alarmCount'];
    }

    public function findChunkByIds($startId, $endId)
    {
        $qb = $this->createQueryBuilder('t');
        $query = $qb
            ->select("t")
            ->where('t.id > :startId')
            ->andWhere('t.id <= :endId')
            ->setParameter('startId', $startId)
            ->setParameter('endId', $endId);

        return $query->getQuery()->getResult();
    }
}