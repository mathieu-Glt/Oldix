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
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     * @Assert\NotBlank(message="The movie must have a name")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     * @Assert\NotBlank(message="The movie must have a link")
     * @Assert\Url(message="This link is not correct")
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})     
     */
    private $pictureUrl;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $releasedDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $realisator;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $synopsis;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="movies")
     * @Groups({"browse_movie","movies_search","movie_read","list_movie_add","list_movie_show"})
     * @Assert\NotBlank(message="The movie must be related to at least one category")
     * @Assert\Valid
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Thematic::class, inversedBy="movies")
     * @Groups({"browse_movie","read_category","movies_search","movie_read","list_movie_add","list_movie_show"})
     * @Assert\Valid
     */
    private $thematics;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"browse_movie","read_category","movies_search","movie_read","list_movie_add","list_movie_show"})
     * @Assert\NotBlank(message="The movie must be related to one language")
     * @Assert\Valid
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="movies")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favoriteMovies")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="movie")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Rate::class, mappedBy="movie")
     */
    private $rates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $runTime;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $actors;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $illustration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"browse_movie","read_category","movies_search","read_thematic","movie_read","list_movie_add","list_movie_show"})
     */
    private $averageRate;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->thematics = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->rates = new ArrayCollection();
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
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Thematic[]
     */
    public function getThematics(): Collection
    {
        return $this->thematics;
    }

    public function addThematic(Thematic $thematic): self
    {
        if (!$this->thematics->contains($thematic)) {
            $this->thematics[] = $thematic;
        }

        return $this;
    }

    public function removeThematic(Thematic $thematic): self
    {
        $this->thematics->removeElement($thematic);

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteMovie($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteMovie($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMovie($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovie() === $this) {
                $comment->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setMovie($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getMovie() === $this) {
                $rate->setMovie(null);
            }
        }

        return $this;
    }

    public function getRunTime(): ?string
    {
        return $this->runTime;
    }

    public function setRunTime(?string $runTime): self
    {
        $this->runTime = $runTime;

        return $this;
    }

    public function getActors(): ?string
    {
        return $this->actors;
    }

    public function setActors(?string $actors): self
    {
        $this->actors = $actors;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getAverageRate(): ?int
    {
        return $this->averageRate;
    }

    public function setAverageRate(?int $averageRate): self
    {
        $this->averageRate = $averageRate;

        return $this;
    }
}
