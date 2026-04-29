<?php

namespace App\Entity;

use App\Repository\AproposRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AproposRepository::class)]
class Apropos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getMedia1(): ?string
    {
        return $this->media1;
    }

    public function setMedia1(?string $media1): static
    {
        $this->media1 = $media1;

        return $this;
    }

    public function getMedia2(): ?string
    {
        return $this->media2;
    }

    public function setMedia2(?string $media2): static
    {
        $this->media2 = $media2;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(?bool $isActif): static
    {
        $this->isActif = $isActif;

        return $this;
    }
}
