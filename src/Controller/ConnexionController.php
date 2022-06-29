<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ConnexionController extends AbstractController
{
    //§ ========================================== Login ==========================================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $last_username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', compact('last_username', 'error'));
    }



    //§ ========================================= Logout ==========================================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
