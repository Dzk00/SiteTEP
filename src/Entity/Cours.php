<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_cours = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_cours = null;

    #[ORM\OneToMany(mappedBy: 'cours_ad', targetEntity: Adherents::class)]
    private Collection $adherents;

    public function __construct()
    {
        $this->adherents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nom_cours;
    }

    public function setNomCours(string $nom_cours): static
    {
        $this->nom_cours = $nom_cours;

        return $this;
    }

    public function getHeureCours(): ?string
    {
        return $this->heure_cours;
    }

    public function setHeureCours(string $heure_cours): static
    {
        $this->heure_cours = $heure_cours;

        return $this;
    }

    /**
     * @return Collection<int, Adherents>
     */
    public function getadherents(): Collection
    {
        return $this->adherents;
    }

    public function addAdherents(Adherents $adherents): static
    {
        if (!$this->adherents->contains($adherents)) {
            $this->adherents->add($adherents);
            $adherents->setCoursAd($this);
        }

        return $this;
    }

    public function removeAdherents(Adherents $adherents): static
    {
        if ($this->adherents->removeElement($adherents)) {
            // set the owning side to null (unless already changed)
            if ($adherents->getCoursAd() === $this) {
                $adherents->setCoursAd(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNomCours(); 
    }
}
