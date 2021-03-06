<?php

namespace Ferus\EventBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Ferus\EventBundle\Entity\Event;

/**
 * CarRequestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CarRequestRepository extends EntityRepository
{
    public function findFromEvent(Event $event)
    {
        return $this->createQueryBuilder('r')
            ->select('s.firstName Prenom, s.lastName Nom, s.email Email, r.brand Marque, r.model Model, r.color Couleur, r.plate Plaque')
            ->join('FerusEventBundle:Payment', 's', Query\Expr\Join::WITH, 's.email = r.email')
            ->where('s.event = :event AND r.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }
}
