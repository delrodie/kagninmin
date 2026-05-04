<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legende = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $uploadedAt = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Actualite $Actualite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): static
    {
        $this->legende = $legende;

        return $this;
    }

    public function getuploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function setuploadedAt(?\DateTimeImmutable $uploadedAt): static
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    public function getActualite(): ?Actualite
    {
        return $this->Actualite;
    }

    public function setActualite(?Actualite $Actualite): static
    {
        $this->Actualite = $Actualite;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUploadedAtValue(): \DateTimeImmutable
    {
        return $this->uploadedAt = new \DateTimeImmutable();
    }
}
