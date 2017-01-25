<?php
/**
 * Class ${CLASS_NAME}
 *
 * This Software is the property of superReal and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @link http://www.superreal.de
 * @copyright (C) superReal 2017
 * @author Tadas Barauskas <t.barauskas _AT_ superreal.de>
 */

namespace ShopBundle\Controller;


use ShopBundle\Form\UserType;
use ShopBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('ShopBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('ShopBundle:Security:register.html.twig', ['form' => $form->createView()]);
    }
}