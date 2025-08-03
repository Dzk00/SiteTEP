<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlogRepository;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 100)]
    private ?string $titre_court = null;

    #[ORM\Column(length: 275)]
    private ?string $description_courte = null;

    #[ORM\Column(length: 550)]
    private ?string $description_longue_un = null;

    #[ORM\Column(length: 550)]
    private ?string $description_longue_2 = null;

    /**
     * @Vich\UploadableField(mapping="prestations", fileNameProperty="imageName")
     */
    private ?string $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;
    
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTitreCourt(): ?string
    {
        return $this->titre_court;
    }

    public function setTitreCourt(string $titre_court): static
    {
        $this->titre_court = $titre_court;

        return $this;
    }

    public function getDescriptionCourte(): ?string
    {
        return $this->description_courte;
    }

    public function setDescriptionCourte(string $description_courte): static
    {
        $this->description_courte = $description_courte;

        return $this;
    }

    public function getDescriptionLongueUn(): ?string
    {
        return $this->description_longue_un;
    }

    public function setDescriptionLongueUn(string $description_longue_un): static
    {
        $this->description_longue_un = $description_longue_un;

        return $this;
    }

    public function getDescriptionLongue2(): ?string
    {
        return $this->description_longue_2;
    }

    public function setDescriptionLongue2(string $description_longue_2): static
    {
        $this->description_longue_2 = $description_longue_2;

        return $this;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?string $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->imageName = $imageFile;
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

}
