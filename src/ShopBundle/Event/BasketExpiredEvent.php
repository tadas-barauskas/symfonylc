<?php

namespace ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ShopBundle\Entity\Basket;

class BasketExpiredEvent extends Event
{
    const NAME = 'basket.expired';

    protected $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function getBasket()
    {
        return $this->basket;
    }
}
