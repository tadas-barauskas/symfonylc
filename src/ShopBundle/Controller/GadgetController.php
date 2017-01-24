<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GadgetController extends Controller
{
    public function listAction($page)
    {
        $gadgets = $this->get('shop.gadget_repository')->findAllGadgets($page);

        return $this->render('ShopBundle:Gadget:list.html.twig', compact('gadgets'));
    }

    public function detailAction($id)
    {
        $gadget = $this->get('shop.gadget_repository')->find($id);

        return $this->render('ShopBundle:Gadget:detail.html.twig', compact('gadget'));
    }
}
