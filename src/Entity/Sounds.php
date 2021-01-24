<?php

namespace App\Entity;

use App\Repository\SoundsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoundsRepository::class)
 */
class Sounds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artiste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity=Audios::class, mappedBy="sounds", orphanRemoval=true, cascade={"persist"})
     */
    private $audios;

    public function __construct()
    {
        $this->audios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection|Audios[]
     */
    public function getAudios(): Collection
    {
        return $this->audios;
    }

    public function addAudio(Audios $audio): self
    {
        if (!$this->audios->contains($audio)) {
            $this->audios[] = $audio;
            $audio->setSounds($this);
        }

        return $this;
    }

    public function removeAudio(Audios $audio): self
    {
        if ($this->audios->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getSounds() === $this) {
                $audio->setSounds(null);
            }
        }

        return $this;
    }
}
