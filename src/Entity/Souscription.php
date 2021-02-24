<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity(repositoryClass="App\Repository\SouscriptionRepository")
 */
class Souscription
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
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="relation")
     */
    private $relationUserSouscrip;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="relationSouscripOffer")
     */
    private $relation;


    public function __construct(User $user, Offer $offer)
    {
        $this->user = $user;
        $this->offer = $offer;
        $this->etat = 'en attente';

        //initialiser les valeurs herités

        $this->relationUserSouscrip = $user->getId();  // user
        $this->relation = $offer->getId();  // offre


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRelationUserSouscrip(): ?User
    {
        return $this->relationUserSouscrip;
    }

    public function setRelationUserSouscrip(?User $relationUserSouscrip): self
    {
        $this->relationUserSouscrip = $relationUserSouscrip;

        return $this;
    }

    public function getRelation(): ?Offer
    {
        return $this->relation;
    }

    public function setRelation(?Offer $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
