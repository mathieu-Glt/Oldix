<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RateRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RateRepository::class)
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"rate_add_response"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"rate_add_response", "movie_browse","category_read","movies_search","thematic_read","movie_read","list_movie_add","list_movie_show"})
     * 
     * @Assert\Type(type = "integer", message = "Movie's rate must be a number")
     * @Assert\Range(min = 0, max = 5,minMessage = "Movie's rate must be between 0 and 5",maxMessage = "Movie's rate must be between 0 and 5")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

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
