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
        $em = $this->getDoctrine()->getManager();
        $em->persist($basket);
        $em->flush();

        return $basket;
    }

    private function addItemToBasket($basket, $gadgetId, $amount)
    {
        if (!$basketItem = $basket->getBasketItem($gadgetId)) {
            $basketItem = new BasketItem();
        }
        $em = $this->getDoctrine()->getManager();
        $basketItem->setGadget($em->getReference('ShopBundle:Gadget', $gadgetId));
        $basketItem->setAmount($amount);
        $basketItem->setBasket($basket);

        $em->persist($basketItem);
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
