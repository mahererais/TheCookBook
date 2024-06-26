<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank(message="Le titre de la recette est obligatoire")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url
     * 
     */
    private $picture;

    /**
     * @ORM\Column(type="array")
     * 
     */
    private $steps = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Vous devez choisir le statut de la recette")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=128)
     * 
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     */
    private $duration;

    /**
     * @ORM\Column(type="array")
     * 
     */
    private $ingredients = [];

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Vous devez faire un choix")
     */
    private $ebook;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favorites")
     */
    private $favorites;

    private $request;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        if (empty($this->picture))
            return "https://zupimages.net/up/23/36/58jq.png";

        return $this->picture;
    }

    public function setPicture(string $picture = "https://zupimages.net/up/23/36/58jq.png"): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSteps(): ?array
    {
        return $this->steps;
    }

    public function setSteps(array $steps): self
    {
        $this->steps = $steps;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

     /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    /**
     * update field updated_at when user update recipe information
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isEbook(): ?string
    {
        return $this->ebook;
    }

    public function setEbook(string $ebook): self
    {
        $this->ebook = $ebook;

        return $this;
    }

    public function removeFromEbook(): self
    {
        $this->setEbook('0');

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(User $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->addFavorite($this);
        }

        return $this;
    }

    public function removeFavorite(User $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            $favorite->removeFavorite($this);
        }

        return $this;
    }


}
