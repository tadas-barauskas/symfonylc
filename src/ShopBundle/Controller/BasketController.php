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
        $gadgetId = $request->get('gadgetId');
        $amount = $request->get('amount');
        $this->addItemToBasket($basket, $gadgetId, $amount);
        $this->updateBasket($basket);

        return $this->redirectToRoute('shop_gadget_detail', ['id' => $gadgetId]);
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
        $this->saveEntity($basket);

        return $basket;
    }

    private function addItemToBasket($basket, $gadgetId, $amount)
    {
        if (!$basketItem = $basket->getBasketItem($gadgetId)) {
            $basketItem = new BasketItem();
        }
        $basketItem->setGadget($this->getGadgetReference($gadgetId));
        $basketItem->setAmount($amount);
        $basketItem->setBasket($basket);
        $this->saveEntity($basketItem);
    }

    private function getGadgetReference($gadgetId)
    {
        $em = $this->getDoctrine()->getManager();
        $gadgetReference = $em->getReference('ShopBundle:Gadget', $gadgetId);

        return $gadgetReference;
    }

    private function updateBasket($basket)
    {
        $basket->updateTimestamp();
        $this->saveEntity($basket);
    }

    private function saveEntity($basket)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($basket);
        $em->flush();
    }

    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('ShopBundle:BasketItem')->find($id);
        if ($this->getBasket()->containsItem($item)) {
            $em->remove($item);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
