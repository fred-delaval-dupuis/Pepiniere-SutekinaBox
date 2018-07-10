<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxProductRepository")
 */
class BoxProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $receptionDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $valid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Box", inversedBy="boxProducts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Box
     */
    private $box;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="boxProducts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Product
     */
    private $product;

    /**
     * BoxProduct constructor.
     * @param Box|null $box
     * @param Product|null $product
     * @param int|null $quantity
     * @param \DateTime|null $receptionDate
     * @param bool|null $valid
     */
    public function __construct(Box $box = null, Product $product = null, int $quantity = null, \DateTime $receptionDate = null, bool $valid = null)
    {
        $this->quantity = $quantity;
        $this->receptionDate = $receptionDate;
        $this->valid = $valid;
        $this->box = $box;
        $this->product = $product;
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
     * @return BoxProduct
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return BoxProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceptionDate()
    {
        return $this->receptionDate;
    }

    /**
     * @param mixed $receptionDate
     * @return BoxProduct
     */
    public function setReceptionDate($receptionDate)
    {
        $this->receptionDate = $receptionDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param mixed $valid
     * @return BoxProduct
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return Box|null
     */
    public function getBox(): ?Box
    {
        return $this->box;
    }

    /**
     * @param Box|null $box
     * @return BoxProduct
     */
    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return BoxProduct
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
