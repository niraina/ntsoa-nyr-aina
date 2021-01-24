<?php

namespace App\Entity;

use App\Repository\AudiosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AudiosRepository::class)
 */
class Audios
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Sounds::class, inversedBy="audios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sounds;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSounds(): ?Sounds
    {
        return $this->sounds;
    }

    public function setSounds(?Sounds $sounds): self
    {
        $this->sounds = $sounds;

        return $this;
    }
}
