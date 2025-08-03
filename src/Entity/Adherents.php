<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\DBAL\Types\AdherentsStateType;
use App\Repository\AdherentsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Fresh\DoctrineEnumBundle\Validator\Constraints\EnumType;

#[ORM\Entity(repositoryClass: AdherentsRepository::class)]
class Adherents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_ad = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_ad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_ad = null;

    #[ORM\Column(length: 255)]
    private ?string $code_postal_ad = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $mail_ad = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance_ad = null;

    #[ORM\Column(length: 255)]
    private ?string $tel_ad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel_pere_ad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel_mere_ad = null;

    #[ORM\Column(length: 255)]
    private ?string $tel_secours_ad = null;

    /**
     * @ORM\Column(type="boolean")
     */    
    private ?bool $autorisation_urgence = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $vaccins_ad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $antecedents_medicaux_ad = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $droit_image_ad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_ad = null;

    #[ORM\ManyToOne(inversedBy: 'adherents')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Cours $cours_ad = null;


    #[ORM\Column(nullable: true)]
    private ?bool $garderie_stage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $sortie_autonome = null;

    #[ORM\ManyToMany(targetEntity: Stages::class, inversedBy: 'adherents')]
    private Collection $stage_ad;

    #[ORM\ManyToMany(targetEntity: StagesHiver::class, inversedBy: 'adherents')]
    private Collection $stage_hiver;

    #[ORM\ManyToMany(targetEntity: StagesPaques::class, inversedBy: 'adherents')]
    private Collection $stage_paques;

    #[ORM\ManyToMany(targetEntity: StagesToussaint::class, inversedBy: 'adherents')]
    private Collection $stage_toussaint;

    /** 
    * @see config/packages/workflow.yaml
    */
   #[ORM\Column(name: 'state', type: 'AdherentsStateType', nullable: false)]
   #[EnumType(entity: AdherentsStateType::class)]
   private string $state = AdherentsStateType::STATE_CREATED;

    public function __construct()
    {
        $this->stage_ad = new ArrayCollection();
        $this->stage_hiver = new ArrayCollection();
        $this->stage_paques = new ArrayCollection();
        $this->stage_toussaint = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAd(): ?string
    {
        return $this->nom_ad;
    }

    public function setNomAd(string $nom_ad): static
    {
        $this->nom_ad = $nom_ad;

        return $this;
    }

    public function getPrenomAd(): ?string
    {
        return $this->prenom_ad;
    }

    public function setPrenomAd(string $prenom_ad): static
    {
        $this->prenom_ad = $prenom_ad;

        return $this;
    }

    public function getAdresseAd(): ?string
    {
        return $this->adresse_ad;
    }

    public function setAdresseAd(?string $adresse_ad): static
    {
        $this->adresse_ad = $adresse_ad;

        return $this;
    }

    public function getCodePostalAd(): ?string
    {
        return $this->code_postal_ad;
    }

    public function setCodePostalAd(string $code_postal_ad): static
    {
        $this->code_postal_ad = $code_postal_ad;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getMailAd(): ?string
    {
        return $this->mail_ad;
    }

    public function setMailAd(string $mail_ad): static
    {
        $this->mail_ad = $mail_ad;

        return $this;
    }

    public function getDateNaissanceAd(): ?\DateTimeInterface
    {
        return $this->date_naissance_ad;
    }

    public function setDateNaissanceAd(\DateTimeInterface $date_naissance_ad): static
    {
        $this->date_naissance_ad = $date_naissance_ad;

        return $this;
    }

    public function getTelAd(): ?string
    {
        return $this->tel_ad;
    }

    public function setTelAd(string $tel_ad): static
    {
        $this->tel_ad = $tel_ad;

        return $this;
    }

    public function getTelPereAd(): ?string
    {
        return $this->tel_pere_ad;
    }

    public function setTelPereAd(?string $tel_pere_ad): static
    {
        $this->tel_pere_ad = $tel_pere_ad;

        return $this;
    }

    public function getTelMereAd(): ?string
    {
        return $this->tel_mere_ad;
    }

    public function setTelMereAd(?string $tel_mere_ad): static
    {
        $this->tel_mere_ad = $tel_mere_ad;

        return $this;
    }

    public function getTelSecoursAd(): ?string
    {
        return $this->tel_secours_ad;
    }

    public function setTelSecoursAd(?string $tel_secours_ad): static
    {
        $this->tel_secours_ad = $tel_secours_ad;

        return $this;
    }

    public function isAutorisationUrgence(): ?bool
    {
        return $this->autorisation_urgence;
    }

    public function setAutorisationUrgence(bool $autorisation_urgence): static
    {
        $this->autorisation_urgence = $autorisation_urgence;

        return $this;
    }

    public function isVaccinsAd(): ?bool
    {
        return $this->vaccins_ad;
    }

    public function setVaccinsAd(bool $vaccins_ad): static
    {
        $this->vaccins_ad = $vaccins_ad;

        return $this;
    }

    public function getAntecedentsMedicauxAd(): ?string
    {
        return $this->antecedents_medicaux_ad;
    }

    public function setAntecedentsMedicauxAd(?string $antecedents_medicaux_ad): static
    {
        $this->antecedents_medicaux_ad = $antecedents_medicaux_ad;

        return $this;
    }

    public function isDroitImageAd(): ?bool
    {
        return $this->droit_image_ad;
    }

    public function setDroitImageAd(bool $droit_image_ad): static
    {
        $this->droit_image_ad = $droit_image_ad;

        return $this;
    }

    public function getPhotoAd(): ?string
    {
        return $this->photo_ad;
    }

    public function setPhotoAd(?string $photo_ad): static
    {
        $this->photo_ad = $photo_ad;

        return $this;
    }

    public function getCoursAd(): ?Cours
    {
        return $this->cours_ad;
    }

    public function setCoursAd(?Cours $cours_ad): static
    {
        $this->cours_ad = $cours_ad;

        return $this;
    }

    public function isGarderieStage(): ?bool
    {
        return $this->garderie_stage;
    }

    public function setGarderieStage(?bool $garderie_stage): static
    {
        $this->garderie_stage = $garderie_stage;

        return $this;
    }

    public function isSortieAutonome(): ?bool
    {
        return $this->sortie_autonome;
    }

    public function setSortieAutonome(?bool $sortie_autonome): static
    {
        $this->sortie_autonome = $sortie_autonome;

        return $this;
    }

    /**
     * @return Collection<int, Stages>
     */
    public function getStageAd(): Collection
    {
        return $this->stage_ad;
    }


    public function addStageAd(Stages $stageAd): static
    {
        if (!$this->stage_ad->contains($stageAd)) {
            $this->stage_ad->add($stageAd);
        }

        return $this;
    }

    public function removeStageAd(Stages $stageAd): static
    {
        $this->stage_ad->removeElement($stageAd);

        return $this;
    }

    /**
     * @return Collection<int, StagesHiver>
     */
    public function getStageHiver(): Collection
    {
        return $this->stage_hiver;
    }

    public function addStageHiver(StagesHiver $stageHiver): static
    {
        if (!$this->stage_hiver->contains($stageHiver)) {
            $this->stage_hiver->add($stageHiver);
        }

        return $this;
    }

    public function removeStageHiver(StagesHiver $stageHiver): static
    {
        $this->stage_hiver->removeElement($stageHiver);

        return $this;
    }

    /**
     * @return Collection<int, StagesPaques>
     */
    public function getStagePaques(): Collection
    {
        return $this->stage_paques;
    }

    public function addStagePaque(StagesPaques $stagePaque): static
    {
        if (!$this->stage_paques->contains($stagePaque)) {
            $this->stage_paques->add($stagePaque);
        }

        return $this;
    }

    public function removeStagePaque(StagesPaques $stagePaque): static
    {
        $this->stage_paques->removeElement($stagePaque);

        return $this;
    }

    /**
     * @return Collection<int, StagesToussaint>
     */
    public function getStageToussaint(): Collection
    {
        return $this->stage_toussaint;
    }

    public function addStageToussaint(StagesToussaint $stageToussaint): static
    {
        if (!$this->stage_toussaint->contains($stageToussaint)) {
            $this->stage_toussaint->add($stageToussaint);
        }

        return $this;
    }

    public function removeStageToussaint(StagesToussaint $stageToussaint): static
    {
        $this->stage_toussaint->removeElement($stageToussaint);

        return $this;
    }
    public function __toString()
    {
        $stageNames = [];

        foreach ($this->stage_ad as $stage) {
            $stageNames[] = $stage->getNomStage();
        }
    
        return implode(', ', $stageNames); 
    }
    
    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState($state): static
    {
        $this->state = $state;

        return $this;
    }
}
