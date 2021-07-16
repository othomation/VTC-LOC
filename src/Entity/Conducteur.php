<?php

namespace App\Entity;

use App\Repository\ConducteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConducteurRepository::class)
 */
class Conducteur {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Vehicule::class, mappedBy="conduteur")
     */
    private $vehicules;

    /**
     * @ORM\OneToMany(targetEntity=Association::class, mappedBy="conducteur")
     */
    private $associations;

    public function __construct() {
        $this->vehicules = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Vehicule[]
     */
    public function getVehicules(): Collection {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): self {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules[] = $vehicule;
            $vehicule->addConduteur($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): self {
        if ($this->vehicules->removeElement($vehicule)) {
            $vehicule->removeConduteur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Association[]
     */
    public function getAssociations(): Collection {
        return $this->associations;
    }

    public function addAssociation(Association $association): self {
        if (!$this->associations->contains($association)) {
            $this->associations[] = $association;
            $association->setConducteur($this);
        }

        return $this;
    }

    public function removeAssociation(Association $association): self {
        if ($this->associations->removeElement($association)) {
            // set the owning side to null (unless already changed)
            if ($association->getConducteur() === $this) {
                $association->setConducteur(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->nom . ' ' . $this->prenom . PHP_EOL . $this->id;
    }
}
