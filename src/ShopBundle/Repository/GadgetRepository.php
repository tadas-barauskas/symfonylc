<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * GadgetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GadgetRepository extends EntityRepository
{
    private $paginator;

    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
    }
    
    public function findAllGadgets($page)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT g FROM ShopBundle:Gadget g'
            );
        $pagination = $this->paginate($query, $page);

        return $pagination;
    }

    public function findForSearch($needle, $page)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT g FROM ShopBundle:Gadget g WHERE g.title like :needle or g.manufacturer like :needle"
            )
            ->setParameter('needle', "%$needle%");
        $paginator = $this->paginate($query, $page);

        return $paginator;
    }

    public function paginate($query, $page = 1, $limit = 12)
    {
        $pagination = $this->paginator->paginate($query, $page, $limit);

        return $pagination;
    }
}