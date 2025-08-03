<?php

namespace App\Entity;

use App\Repository\StagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagesRepository::class)]
class Stages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_stage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Max = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $Chunk = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;

    #[ORM\ManyToMany(targetEntity: Adherents::class, mappedBy: 'stage_ad')]
    private Collection $adherents;

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

    public function isMax(): ?bool
    {
        return $this->Max;
    }

    public function setMax(?bool $Max): static
    {
        $this->Max = $Max;

        return $this;
    }

    public function getChunk(): ?string
    {
        return $this->Chunk;
    }

    public function setChunk(?string $Chunk): static
    {
        $this->Chunk = $Chunk;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
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
            $adherent->addStageAd($this);
        }

        return $this;
    }

    public function removeAdherent(Adherents $adherent): static
    {
        if ($this->adherents->removeElement($adherent)) {
            $adherent->removeStageAd($this);
        }

        return $this;
    }
}
