<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Objet $objet = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isRead = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $readedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $readedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $sendedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(?bool $isRead): static
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getReadedAt(): ?\DateTimeImmutable
    {
        return $this->readedAt;
    }

    public function setReadedAt(?\DateTimeImmutable $readedAt): static
    {
        $this->readedAt = $readedAt;

        return $this;
    }

    public function getReadedBy(): ?string
    {
        return $this->readedBy;
    }

    public function setReadedBy(?string $readedBy): static
    {
        $this->readedBy = $readedBy;

        return $this;
    }

    public function getSendedAt(): ?\DateTimeImmutable
    {
        return $this->sendedAt;
    }

    public function setSendedAt(?\DateTimeImmutable $sendedAt): static
    {
        $this->sendedAt = $sendedAt;

        return $this;
    }
}
