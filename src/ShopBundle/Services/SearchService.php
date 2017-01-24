<?php

namespace ShopBundle\Services;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;

class SearchService
{
    private $formFactory;
    private $router;

    public function __construct(FormFactory $formFactory, Router $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function getSearchFormView()
    {
        $form = $this->getSearchForm();

        return $form->createView();
    }

    public function getSearchForm()
    {
        $form = $this->formFactory->createBuilder()
            ->setAction($this->router->generate('shop_gadget_search'))
            ->add('search', TextType::class)
            ->getForm();

        return $form;
    }
}