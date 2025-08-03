<?php

namespace App\Entity;

use App\Repository\StagesHiverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagesHiverRepository::class)]
class StagesHiver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_stage = null;

    #[ORM\ManyToMany(targetEntity: Adherents::class, mappedBy: 'stage_hiver')]
    private Collection $adherents;

    #[ORM\Column(length: 10)]
    private ?string $Type = null;

    #[ORM\Column]
    private ?bool $Max = null;

    public function __construct()
    {
        $this->adherents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStage(): ?string
    {
        return $this->nom_stage;
    }

    public function setNomStage(string $nom_stage): static
    {
        $this->nom_stage = $nom_stage;

        return $this;
    }
    public function __toString()
    {
        return $this->getNomStage(); 
    }

    /**
     * @return Collection<int, Adherents>
     */
    public function getAdherents(): Collection
    {
        return $this->adherents;
    }

    public function addAdherent(Adherents $adherent): static
    {
        if (!$this->adherents->contains($adherent)) {
            $this->adherents->add($adherent);
            $adherent->addStageHiver($this);
        }

        return $this;
    }

    public function removeAdherent(Adherents $adherent): static
    {
        if ($this->adherents->removeElement($adherent)) {
            $adherent->removeStageHiver($this);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function isMax(): ?bool
    {
        return $this->Max;
    }

    public function setMax(bool $Max): static
    {
        $this->Max = $Max;

        return $this;
    }

}
