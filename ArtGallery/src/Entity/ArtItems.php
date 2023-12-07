<?php

namespace App\Entity;

use App\Repository\ArtItemsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtItemsRepository::class)]
class ArtItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $artist_first_name = null;

    #[ORM\Column(length: 30)]
    private ?string $artist_last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $production_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getArtistFirstName(): ?string
    {
        return $this->artist_first_name;
    }

    public function setArtistFirstName(string $artist_first_name): static
    {
        $this->artist_first_name = $artist_first_name;

        return $this;
    }

    public function getArtistLastName(): ?string
    {
        return $this->artist_last_name;
    }

    public function setArtistLastName(string $artist_last_name): static
    {
        $this->artist_last_name = $artist_last_name;

        return $this;
    }

    public function getProductionDate(): ?\DateTimeInterface
    {
        return $this->production_date;
    }

    public function setProductionDate(\DateTimeInterface $production_date): static
    {
        $this->production_date = $production_date;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
