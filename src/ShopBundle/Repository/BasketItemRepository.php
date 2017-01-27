<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BasketItemRepository extends EntityRepository
{
    public function findUserBasket($userId)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT b FROM ShopBundle:Basket b WHERE useri'
            );

        return $query;
    }
}
