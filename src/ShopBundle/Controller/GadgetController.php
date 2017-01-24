<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GadgetController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gadgets = $em->getRepository('ShopBundle:Gadget')->findAllGadgets();

        return $this->render('ShopBundle:Gadget:list.html.twig', compact('gadgets'));
    }

    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gadget = $em->getRepository('ShopBundle:Gadget')->find($id);

        return $this->render('ShopBundle:Gadget:detail.html.twig', compact('gadget'));
    }
}
