<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $immatriculation;

    /**
     * @ORM\ManyToMany(targetEntity=Conducteur::class, inversedBy="vehicules")
     */
    private $conduteur;

    /**
     * @ORM\OneToMany(targetEntity=Association::class, mappedBy="vehicule")
     */
    private $associations;

    public function __construct() {
        $this->conduteur = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getMarque(): ?string {
        return $this->marque;
    }

    public function setMarque(string $marque): self {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string {
        return $this->modele;
    }

    public function setModele(string $modele): self {
        $this->modele = $modele;

        return $this;
    }

    public function getCouleur(): ?string {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self {
        $this->couleur = $couleur;

        return $this;
    }

    public function getImmatriculation(): ?string {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * @return Collection|Conducteur[]
     */
    public function getConduteur(): Collection {
        return $this->conduteur;
    }

    public function addConduteur(Conducteur $conduteur): self {
        if (!$this->conduteur->contains($conduteur)) {
            $this->conduteur[] = $conduteur;
        }

        return $this;
    }

    public function removeConduteur(Conducteur $conduteur): self {
        $this->conduteur->removeElement($conduteur);

        return $this;
    }

    public function __toString() {
        return $this->marque . PHP_EOL . $this->id;
    }

    /**
     * @return Collection|Association[]
     */
    public function getAssociations(): Collection
    {
        return $this->associations;
    }

    public function addAssociation(Association $association): self
    {
        if (!$this->associations->contains($association)) {
            $this->associations[] = $association;
            $association->setVehicule($this);
        }

        return $this;
    }

    public function removeAssociation(Association $association): self
    {
        if ($this->associations->removeElement($association)) {
            // set the owning side to null (unless already changed)
            if ($association->getVehicule() === $this) {
                $association->setVehicule(null);
            }
        }

        return $this;
    }
}
