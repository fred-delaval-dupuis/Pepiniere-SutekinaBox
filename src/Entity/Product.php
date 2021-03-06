<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @Assert\NotBlank(message="assert.product.label.notblank")
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $label;

    /**
     * @Assert\NotBlank(message="assert.product.description.notblank")
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $description;

    /**
     * @Assert\NotBlank(message="assert.product.price.notblank")
     * @Assert\GreaterThan(value=0, message="assert.product.price.greaterthan")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $price;

    /**
     * @Assert\NotBlank(message="assert.product.stock.notblank")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Supplier
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoxProduct", mappedBy="product", orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    private $boxProducts;

    /**
     * Product constructor.
     * @param string $label
     * @param string $description
     * @param int $price
     * @param int $stock
     * @param Supplier $supplier
     * @param ArrayCollection $boxProducts
     */
    public function __construct(string $label = null, string $description = null, int $price = null, int $stock = null, Supplier $supplier = null, ArrayCollection $boxProducts = null)
    {
        $this->label = $label;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->supplier = $supplier;
        $this->boxProducts = $boxProducts ?: new ArrayCollection();
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
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return Product
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @return Supplier|null
     */
    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @param Supplier|null $supplier
     * @return Product
     */
    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

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
     * @return Product
     */
    public function addBoxProduct(BoxProduct $boxProduct): self
    {
        if (!$this->boxProducts->contains($boxProduct)) {
            $this->boxProducts[] = $boxProduct;
            $boxProduct->setProduct($this);
        }

        return $this;
    }

    /**
     * @param BoxProduct $boxProduct
     * @return Product
     */
    public function removeBoxProduct(BoxProduct $boxProduct): self
    {
        if ($this->boxProducts->contains($boxProduct)) {
            $this->boxProducts->removeElement($boxProduct);
            // set the owning side to null (unless already changed)
            if ($boxProduct->getProduct() === $this) {
                $boxProduct->setProduct(null);
            }
        }

        return $this;
    }

}
