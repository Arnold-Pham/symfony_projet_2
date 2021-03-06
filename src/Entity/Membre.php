<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\MembreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ORM\Table(name: '`membre`')]
#[UniqueEntity(fields: ['pseudo', 'email'])]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20, unique: true)]
    #[Assert\Length(min: 3)]
    private $pseudo;

    #[ORM\Column(type: 'string', length: 60)]
    #[Assert\Length(min: 6)]
    private $password;

    #[ORM\Column(type: 'string', length: 1)]
    #[Assert\Choice(callback: 'sexe')]
    private $civilite;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Length(min: 3)]
    private $nom;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Length(min: 3)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email()]
    private $email;

    #[ORM\Column(type: 'integer')]
    #[Assert\Choice(callback: 'varStatut')]
    private $statut;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type("datetime")]
    private $date_enregistrement;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Commande::class)]
    private $commandes;


    public function sexe(): array
    {
        return ['M', 'F'];
    }

    public function varStatut(): array
    {
        return [0, 1];
    }

    public function __construct()
    {
        $tz = new \DateTimeZone('Europe/Paris');
        $now = new \DateTime();
        $now->setTimezone($tz);
        $this->setDateEnregistrement($now);
        $this->setStatut(0);

        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setMembre($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMembre() === $this) {
                $commande->setMembre(null);
            }
        }

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
}
