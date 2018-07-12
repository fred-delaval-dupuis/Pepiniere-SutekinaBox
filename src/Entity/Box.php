<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxRepository")
 */
class Box
{
    const BOX_CREATED           = 'box_created';
    const BOX_FILLED            = 'box_filled';
    const VALIDATION            = 'validation';
    const INVALIDATED           = 'invalidated';
    const GO                    = 'go';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="assert.box.title.notblank")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotNull(message="assert.box.budget.notnull")
     * @Assert\GreaterThan(value=0, message="assert.box.budget.greaterthan")
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
     * @ORM\Column(type="string", length=64)
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
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Box
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
