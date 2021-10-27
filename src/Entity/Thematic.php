<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThematicRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ThematicRepository::class)
 */
class Thematic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","browse_thematic","movie_read"})
     * @Assert\NotBlank(message="Thematic must have a name")
     * @Assert\Regex(
     *              pattern="/[a-z]+/"
     *            )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"browse_movie","read_category","movies_search","browse_thematic","movie_read"})
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, mappedBy="thematic")
     * @Groups({"read_thematic"})
     * @Assert\Valid
     */
    private $movies;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="thematics")
     */
    private $user;


    public function __construct()
    {
        $this->movies = new ArrayCollection();
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

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addThematic($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeThematic($this);
        }

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
