<?php

namespace App\Controller;


use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Services\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/vehicule')]
class VehiculeController extends AbstractController
{
    private $em;
    private $imgService;
    public function __construct(EntityManagerInterface $em, ImageService $imgService)
    {
        $this->em = $em;
        $this->imgService = $imgService;
    }



    //§ =============================== INDEX (Liste des Véhicules) ===============================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/', name: 'vehicule_index', methods: ['GET'])]
    public function index(): Response
    {
        $vehicules = $this->em->getRepository(Vehicule::class)->findAll();

        return $this->render('vehicule/index.html.twig', compact('vehicules'));
    }



    //§ ================================ NEW (Ajout d'un Véhicule) ================================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/new', name: 'vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['photo']->getData();

            if ($file) {
                $this->imgService->moveImage($file, $vehicule);
            }

            $this->em->persist($vehicule);
            $this->em->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->renderForm('vehicule/new.html.twig', compact('form'));
    }



    //§ ============================== SHOW (Détails d'un Véhicule) ===============================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/{id}', name: 'vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', compact('vehicule'));
    }



    //§ ============================ EDIT (Mise à jour d'un Véhicule) =============================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/{id}/edit', name: 'vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Vehicule $vehicule, Request $request): Response
    {
        if (is_null($vehicule)) {

            return $this->redirectToRoute('vehicule_index');
        }

        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['photo']->getData();

            if ($file) {
                $this->imgService->updImage($file, $vehicule);
            }

            $this->em->persist($vehicule);
            $this->em->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->renderForm('vehicule/edit.html.twig', compact('vehicule', 'form'));
    }



    //§ =========================== DELETE (Suppression d'un Véhicule) ============================
    //* ------------------------------------- [ Fonctionnel ] -------------------------------------

    #[Route('/{id}', name: 'vehicule_delete', methods: ['POST'])]
    public function delete(Vehicule $vehicule): Response
    {
        if ($vehicule) {

            if (!is_null($vehicule->getPhoto())) {
                $this->imgService->delImage($vehicule);
            }

            $this->em->remove($vehicule);
            $this->em->flush();
        }

        return $this->redirectToRoute('vehicule_index');
    }
}
