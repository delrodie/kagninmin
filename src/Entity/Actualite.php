<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', "Cette actualité a déjà été enregistrée.")]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'actualites')]
    private ?Domaine $domaine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAtif = null;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'Actualite', cascade: ['persist', 'remove'])]
    private Collection $photos;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateAction = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
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


    public function isAtif(): ?bool
    {
        return $this->isAtif;
    }

    public function setIsAtif(?bool $isAtif): static
    {
        $this->isAtif = $isAtif;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setActualite($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getActualite() === $this) {
                $photo->setActualite(null);
            }
        }

        return $this;
    }

    public function getDateAction(): ?\DateTime
    {
        return $this->dateAction;
    }

    public function setDateAction(?\DateTime $dateAction): static
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Champ virtuel pour l'upload multiple (non persisté)
     * @var UploadedFile[]|null
     */
    private ?array $photosFiles = null;

    // Getter / Setter
    public function getPhotosFiles(): ?array
    {
        return $this->photosFiles;
    }

    public function setPhotosFiles(?array $photosFiles): self
    {
        $this->photosFiles = $photosFiles;
        return $this;
    }

    // Optionnel : méthode helper pour créer les photos
    public function addPhotosFromFiles(array $files): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $photo = new Photo();
                $photo->setMedia($file->getClientOriginalName()); // ou un nom unique
                // Vous pouvez aussi gérer le vrai upload ici ou dans un listener
                $this->addPhoto($photo);
            }
        }
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setPublishedAtValue(): \DateTimeImmutable
    {
        return $this->publishedAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setSlugValue()
    {
        $slug = strtolower(new AsciiSlugger()->slug($this->getTitre()));
        return $this->setSlug($slug);
    }

    public function __toString(): string
    {
        return $this->titre;
    }
}
