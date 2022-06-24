<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('datetime')]
    #[Assert\GreaterThanOrEqual('today')]
    private $date_heure_depart;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('datetime')]
    #[Assert\GreaterThan(propertyPath: 'date_heure_depart', message: 'Doit être supérieur à la date de départ.')]
    private $date_heure_fin;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\GreaterThan(value: 30)]
    private $prix_total;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('datetime')]
    private $date_enregistrement;

    #[ORM\ManyToOne(targetEntity: Membre::class, inversedBy: 'commandes', cascade: ['persist'])]
    private $membre;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'commandes', cascade: ['persist'])]
    private $vehicule;

    
    public function __construct()
    {
        $tz = new \DateTimeZone('Europe/Paris');
        $now = new \DateTime();
        $now->setTimezone($tz);
        $this->setDateEnregistrement($now);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->date_heure_depart;
    }

    public function setDateHeureDepart(\DateTimeInterface $date_heure_depart): self
    {
        $this->date_heure_depart = $date_heure_depart;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->date_heure_fin;
    }

    public function setDateHeureFin(\DateTimeInterface $date_heure_fin): self
    {
        $this->date_heure_fin = $date_heure_fin;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prix_total;
    }

    public function setPrixTotal(int $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }    
}
