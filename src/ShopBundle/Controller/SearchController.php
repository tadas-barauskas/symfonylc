<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function listAction(Request $request, $needle = null)
    {
        if(is_null($needle)){
            $needle = $request->request->get('form')['search'];
        }
        $needle = htmlspecialchars($needle, ENT_HTML5);
        $em = $this->getDoctrine()->getManager();
        $gadgets = $em->getRepository('ShopBundle:Gadget')->findForSearch($needle);

        return $this->render('ShopBundle:Search:list.html.twig', compact('gadgets', 'needle'));
    }
}
