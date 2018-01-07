<?php
namespace Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AlarmFormattedRepository
 * @package Repository
 */
class AlarmFormattedRepository extends EntityRepository
{
    public function persistFormattedAlarm($formattedAlarm)
    {
        $this->_em->persist($formattedAlarm);
    }

    public function flush()
    {
        $this->_em->flush();
        $this->_em->clear();
    }

}