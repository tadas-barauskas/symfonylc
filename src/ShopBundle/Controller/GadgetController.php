<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GadgetController extends Controller
{
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $gadgets = $em->getRepository('ShopBundle:Gadget')->findAllGadgets($page);
        $maxPages = ceil($gadgets->count() / 12);

        return $this->render('ShopBundle:Gadget:list.html.twig', compact('gadgets', 'page', 'maxPages'));
    }

    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gadget = $em->getRepository('ShopBundle:Gadget')->find($id);

        return $this->render('ShopBundle:Gadget:detail.html.twig', compact('gadget'));
    }
}
