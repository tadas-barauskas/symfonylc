<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function listAction(Request $request, $page = 1)
    {
        $needle = $request->request->get('form')['search'];
        $needle = htmlspecialchars($needle, ENT_HTML5);
        $gadgets = $this->get('shop.gadget_repository')->findForSearch($needle, $page);

        return $this->render('ShopBundle:Search:list.html.twig', compact('gadgets', 'needle'));
    }
}
