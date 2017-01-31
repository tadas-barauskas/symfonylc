<?php

namespace ShopBundle\Command;

use ShopBundle\Event\BasketExpiredEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckBasketsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('shop:check-baskets')
            ->setDescription('Check for outdated baskets')
            ->addArgument('interval', InputArgument::OPTIONAL, 'The interval of basket expiration in minutes.', 5);

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('shop.basket_repository');
        $baskets = $repository->findExpiredBaskets($input->getArgument('interval'));
        $this->dispatchBasketEvents($baskets);
    }

    protected function dispatchBasketEvents($baskets)
    {
        $dispatcher = $this->getContainer()->get('event_dispatcher');
        foreach ($baskets as $basket) {
            $this->dispatchEvent($basket, $dispatcher);
        }
    }

    protected function dispatchEvent($basket, $dispatcher)
    {
        $event = new BasketExpiredEvent($basket);
        $dispatcher->dispatch(BasketExpiredEvent::NAME, $event);
    }
}