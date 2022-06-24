<?php

namespace App\Controller;


use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Form\CommandeMembreType;
use App\Repository\VehiculeRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/commande')]
class CommandeMembreController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/{id}', name: 'commande_user_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $commande = new Commande();
        $commande->setDateHeureDepart(new DateTime('+1 days', new DateTimeZone('Europe/Paris')))
            ->setDateHeureFin(new DateTime('+1 days', new DateTimeZone('Europe/Paris')));

        $vehicule = $vehiculeRepository->find($id);
        $form = $this->createForm(CommandeMembreType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prixJour = $vehicule->getPrixJournalier();
            $debut = $form->get('date_heure_depart')->getData();
            $fin = $form->get('date_heure_fin')->getData();
            $nbJours = $debut->diff($fin)->format('%a');

            $jourNomEntier = abs($debut->getTimestamp() - $fin->getTimestamp());
            $jourNomEntier = $jourNomEntier % 86400;

            if ($jourNomEntier != 0) {
                $nbJours += 1;
            }

            $listevehiculeLoue = $this->em->getRepository(Commande::class)->listeVehiculeLoue($debut, $fin);

            if (in_array($vehicule->getId(), $listevehiculeLoue)) {
                $listevehiculeDisponible = $this->em->getRepository(Vehicule::class)->findByVehiculeDisponibles($listevehiculeLoue);
                $this->addFlash('message', 'le véhicule demandé est déjà réservé');
                $this->addFlash('vehicules', ['disponibles' => $listevehiculeDisponible]);
            }

            if (!in_array($vehicule->getId(), $listevehiculeLoue) && $nbJours >= 1) {
                $commande->setPrixTotal($nbJours * $prixJour);
                $commande->setMembre($this->getUser());
                $commande->setVehicule($vehicule);
                $this->em->persist($commande);
                $this->em->flush();
                return $this->redirectToRoute('home');
            }
        }

        return $this->renderForm('commande/new.html.twig', ['form' => $form, 'vehicule' => $vehicule, 'id' => $commande->getId()]);
    }
}
