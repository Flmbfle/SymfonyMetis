<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $artist_name = null;

    #[ORM\OneToMany(targetEntity: Disc::class, mappedBy: 'artist')]
    private Collection $discs;

    #[ORM\OneToMany(targetEntity: Disc::class, mappedBy: 'test')]
    private Collection $disc;

    #[ORM\Column(length: 255)]
    private ?string $artist_url = null;

    public function __construct()
    {
        $this->discs = new ArrayCollection();
        $this->disc = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artist_name;
    }

    public function setArtistName(string $artist_name): static
    {
        $this->artist_name = $artist_name;

        return $this;
    }

    /**
     * @return Collection<int, Disc>
     */
    public function getDiscs(): Collection
    {
        return $this->discs;
    }

    public function addDisc(Disc $disc): static
    {
        if (!$this->discs->contains($disc)) {
            $this->discs->add($disc);
            $disc->setArtist($this);
        }

        return $this;
    }

    public function removeDisc(Disc $disc): static
    {
        if ($this->discs->removeElement($disc)) {
            // set the owning side to null (unless already changed)
            if ($disc->getArtist() === $this) {
                $disc->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Disc>
     */
    public function getDisc(): Collection
    {
        return $this->disc;
    }

    public function getArtistUrl(): ?string
    {
        return $this->artist_url;
    }

    public function setArtistUrl(string $artist_url): static
    {
        $this->artist_url = $artist_url;

        return $this;
    }
}
