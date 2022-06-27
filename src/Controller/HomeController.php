<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }



    //§ ======================================== HOME PAGE ========================================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }



    //§ =============================== BARRE DE RECHERCHE (Search) ===============================
    //? ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/search', name: 'home_search')]
    public function search(Request $request): Response
    {
        $debut = $request->request->get('recherche_debut');
        $fin = $request->request->get('recherche_fin');
        $indispo = $this->em->getRepository(Commande::class)->listeVehiculeLoue($debut, $fin);
        $vehicules = $this->em->getRepository(Vehicule::class)->findByVehiculeDisponibles($indispo);
        dump($vehicules);

        return $this->render('home/results.html.twig', compact('vehicules'));
    }
}
