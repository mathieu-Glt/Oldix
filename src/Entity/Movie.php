<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a name")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a link")
     * @Assert\Url(message="This link is not correct")
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a picture link")
     * @Assert\Url(message="This link is not correct")
     */
    private $pictureUrl;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a released date")
     * @Assert\Regex(
     *          pattern="/\d{4}/",
     *          match=true,
     *          message="The released date must be like YYYY"
     * )
     */
    private $releasedDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a realisator")
     */
    private $realisator;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic"})
     * @Assert\NotBlank(message="The movie must have a synopsis")
     */
    private $synopsis;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="movies")
     * @Groups({"browse_movie","movies_search"})
     * @Assert\NotBlank(message="The movie must be related to at least one category")
     * @Assert\Valid
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Thematic::class, inversedBy="movies")
     * @Groups({"browse_movie","read_category","movies_search"})
     * @Assert\Valid
     */
    private $thematic;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse_movie","read_category","movies_search"})
     * @Assert\NotBlank(message="The movie must be related to one language")
     * @Assert\Valid
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="movies")
     */
    private $user;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->thematic = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    public function getReleasedDate(): ?int
    {
        return $this->releasedDate;
    }

    public function setReleasedDate(int $releasedDate): self
    {
        $this->releasedDate = $releasedDate;

        return $this;
    }

    public function getRealisator(): ?string
    {
        return $this->realisator;
    }

    public function setRealisator(string $realisator): self
    {
        $this->realisator = $realisator;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Thematic[]
     */
    public function getThematic(): Collection
    {
        return $this->thematic;
    }

    public function addThematic(Thematic $thematic): self
    {
        if (!$this->thematic->contains($thematic)) {
            $this->thematic[] = $thematic;
        }

        return $this;
    }

    public function removeThematic(Thematic $thematic): self
    {
        $this->thematic->removeElement($thematic);

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

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
}
