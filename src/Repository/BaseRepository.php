<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class BaseRepository
 * @package Repository
 */
class BaseRepository extends EntityRepository
{
    public function persistEntity($alarm)
    {
        $this->_em->persist($alarm);
        //$this->_em->detach($alarm);
    }

    public function flush()
    {
        $this->_em->flush();
        $this->_em->clear();
    }

    /**
     * @param array $parameters
     * @return \PDO
     */
    protected function buildPDOConnection(array $parameters)
    {
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