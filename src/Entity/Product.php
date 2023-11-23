<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaxonomyTerm", mappedBy="product", cascade={"persist", "remove"})
     */
    private $taxonomyTerms;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;
    
    public function __construct()
    {
        $this->taxonomyTerms = new ArrayCollection();
    }


    public function getTaxonomyTerms(): Collection
    {
        return $this->taxonomyTerms;
    }

    public function addTaxonomyTerm(TaxonomyTerm $taxonomyTerm): self
    {
        if (!$this->taxonomyTerms->contains($taxonomyTerm)) {
            $this->taxonomyTerms[] = $taxonomyTerm;
            $taxonomyTerm->setProduct($this);
        }

        return $this;
    }

    public function removeTaxonomyTerm(TaxonomyTerm $taxonomyTerm): self
    {
        if ($this->taxonomyTerms->removeElement($taxonomyTerm)) {
            // set the owning side to null (unless already changed)
            if ($taxonomyTerm->getProduct() === $this) {
                $taxonomyTerm->setProduct(null);
            }
        }

        return $this;
    }


   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

   
    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
