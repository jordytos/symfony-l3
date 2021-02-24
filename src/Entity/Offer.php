<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texteIntro;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texteOffre;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Souscription::class, mappedBy="relation")
     */
    private $relationSouscripOffer;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->relationSouscripOffer = new ArrayCollection();
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexteIntro(): ?string
    {
        return $this->texteIntro;
    }

    public function setTexteIntro(?string $texteIntro): self
    {
        $this->texteIntro = $texteIntro;

        return $this;
    }

    public function getTexteOffre(): ?string
    {
        return $this->texteOffre;
    }

    public function setTexteOffre(?string $texteOffre): self
    {
        $this->texteOffre = $texteOffre;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Souscription[]
     */
    public function getRelationSouscripOffer(): Collection
    {
        return $this->relationSouscripOffer;
    }

    public function addRelationSouscripOffer(Souscription $relationSouscripOffer): self
    {
        if (!$this->relationSouscripOffer->contains($relationSouscripOffer)) {
            $this->relationSouscripOffer[] = $relationSouscripOffer;
            $relationSouscripOffer->setRelation($this);
        }

        return $this;
    }

    public function removeRelationSouscripOffer(Souscription $relationSouscripOffer): self
    {
        if ($this->relationSouscripOffer->contains($relationSouscripOffer)) {
            $this->relationSouscripOffer->removeElement($relationSouscripOffer);
            // set the owning side to null (unless already changed)
            if ($relationSouscripOffer->getRelation() === $this) {
                $relationSouscripOffer->setRelation(null);
            }
        }

        return $this;
    }
}
