<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'CategoryProduct')]
    private Collection $CategoryProduct;

    public function __construct()
    {
        $this->CategoryProduct = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getCategoryProduct(): Collection
    {
        return $this->CategoryProduct;
    }

    public function addCategoryProduct(Product $categoryProduct): static
    {
        if (!$this->CategoryProduct->contains($categoryProduct)) {
            $this->CategoryProduct->add($categoryProduct);
        }

        return $this;
    }

    public function removeCategoryProduct(Product $categoryProduct): static
    {
        $this->CategoryProduct->removeElement($categoryProduct);

        return $this;
    }
}
