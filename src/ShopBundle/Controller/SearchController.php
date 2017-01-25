<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function listAction(Request $request, $page = 1)
    {
        $needle = $this->getNeedle($request);
        $query = $this->get('shop.gadget_repository')->getSearchQuery($needle);
        $gadgets = $this->get('knp_paginator')->paginate($query, $page, $this->getLimit());

        return $this->render('ShopBundle:Search:list.html.twig', compact('gadgets', 'needle'));
    }

    private function getLimit()
    {
        return $this->getParameter('itemsPerPageLimit');
    }

    private function getNeedle(Request $request)
    {
        $needle = $request->get('search');
        $needle = htmlspecialchars($needle, ENT_HTML5);

        return $needle;
    }
}
