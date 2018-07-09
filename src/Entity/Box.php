<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxRepository")
 */
class Box
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="boxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxProduct", mappedBy="box", orphanRemoval=true)
     */
    private $boxProducts;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->boxProducts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Box
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Box
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     * @return Box
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Box
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|BoxProduct[]
     */
    public function getBoxProducts(): Collection
    {
        return $this->boxProducts;
    }

    /**
     * @param BoxProduct $boxProduct
     * @return Box
     */
    public function addBoxProduct(BoxProduct $boxProduct): self
    {
        if (!$this->boxProducts->contains($boxProduct)) {
            $this->boxProducts[] = $boxProduct;
            $boxProduct->setBox($this);
        }

        return $this;
    }

    /**
     * @param BoxProduct $boxProduct
     * @return Box
     */
    public function removeBoxProduct(BoxProduct $boxProduct): self
    {
        if ($this->boxProducts->contains($boxProduct)) {
            $this->boxProducts->removeElement($boxProduct);
            // set the owning side to null (unless already changed)
            if ($boxProduct->getBox() === $this) {
                $boxProduct->setBox(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Box
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

}
