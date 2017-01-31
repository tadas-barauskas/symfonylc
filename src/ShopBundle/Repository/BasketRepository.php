<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BasketRepository extends EntityRepository
{
    public function findExpiredBaskets($interval)
    {
        $baskets = $this->getEntityManager()
            ->createQuery('SELECT b FROM ShopBundle:Basket b WHERE b.timestamp < :datetime')
            ->setParameter('datetime', new \DateTime("$interval minutes ago"))
            ->getResult();

        return $baskets;
    }
}
