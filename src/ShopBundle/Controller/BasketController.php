<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Basket;
use ShopBundle\Entity\BasketItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends Controller
{
    public function addAction(Request $request)
    {
        $basket = $this->getBasket();
        $gadget = $request->get('gadgetId');
        $amount = $request->get('amount');
        $this->addItemToBasket($basket, $gadget, $amount);

        return $this->redirectToRoute('shop_gadget_detail', ['id' => $gadget]);
    }

    private function getBasket()
    {
        $basket = $this->getUser()->getBasket();
        if (is_null($basket)) {
            $basket = $this->createBasket();
        }
        return $basket;
    }

    private function createBasket()
    {
        $basket = new Basket();
        $basket->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($basket);
        $em->flush();

        return $basket;
    }

    private function addItemToBasket($basket, $gadget, $amount)
    {
        if (!$basketItem = $basket->getBasketItem($gadget)) {
            $basketItem = new BasketItem();
        }
        $basketItem->setGadgetId($gadget);
        $basketItem->setAmount($amount);
        $basketItem->setBasket($basket);

        $em = $this->getDoctrine()->getManager();
        $em->persist($basketItem);
        $em->flush();
    }
}
