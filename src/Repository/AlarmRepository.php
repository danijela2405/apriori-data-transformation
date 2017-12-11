<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class AlarmRepository
 * @package Repository
 */
class AlarmRepository extends EntityRepository
{
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

    private function buildPDOConnection(array $parameters)
    {
        $connectionParams = array(
            'dbname' => 'apriori-transformation',
            'port' => '8000',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );
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