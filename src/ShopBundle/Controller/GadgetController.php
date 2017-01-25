<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GadgetController extends Controller
{
    public function listAction($page)
    {
        $query = $this->get('shop.gadget_repository')->getFindAllGadgetsQuery();
        $gadgets = $this->get('knp_paginator')->paginate($query, $page, $this->getLimit());

        return $this->render('ShopBundle:Gadget:list.html.twig', compact('gadgets'));
    }

    private function getLimit()
    {
        return $this->getParameter('itemsPerPageLimit');
    }

    public function detailAction($id)
    {
        $gadget = $this->get('shop.gadget_repository')->find($id);

        return $this->render('ShopBundle:Gadget:detail.html.twig', compact('gadget'));
    }
}
