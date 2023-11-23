<?php

namespace App\Entity;

use App\Repository\TaxonomyTermRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxonomyTermRepository::class)
 */
class TaxonomyTerm
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
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $term;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="taxonomyTerms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }
}
