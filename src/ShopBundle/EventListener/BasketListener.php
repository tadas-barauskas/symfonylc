<?php

namespace ShopBundle\EventListener;

use Monolog\Logger;
use ShopBundle\Entity\Basket;
use ShopBundle\Event\BasketExpiredEvent;

class BasketListener
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onBasketExpired(BasketExpiredEvent $basketEvent)
    {
        $message = sprintf("User %s has an expired basket",
            $basketEvent->getBasket()->getUser()->getUsername()
        );
        $this->logger->info($message);
    }
}