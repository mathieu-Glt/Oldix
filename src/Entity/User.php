<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="User must have an email")
     * @Assert\Email(message="This value should be like XXX@XXX.com")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="User must have a password")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Movie::class, mappedBy="owner")
     */
    private $movies;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, inversedBy="users")
     */
    private $favoriteMovies;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="owner")
     */
    private $categories;

    /** 
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="users")
     */
    private $favoriteCategories;

    /**
     * @ORM\ManyToMany(targetEntity=Thematic::class, inversedBy="users")
     */
    private $favoriteThematics;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Thematic::class, mappedBy="owner")
     */
    private $thematics;

    /**
     * @ORM\OneToMany(targetEntity=Language::class, mappedBy="owner")
     */
    private $languages;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->favoriteMovies = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->thematics = new ArrayCollection();
        $this->favoriteCategories = new ArrayCollection();
        $this->favoriteThematics = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->thematic = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $movie->setOwner($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getOwner() === $this) {
                $movie->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getFavoriteMovies(): Collection
    {
        return $this->favoriteMovies;
    }

    public function addFavoriteMovie(Movie $favoriteMovie): self
    {
        if (!$this->favoriteMovies->contains($favoriteMovie)) {
            $this->favoriteMovies[] = $favoriteMovie;
        }

        return $this;
    }

    public function removeFavoriteMovie(Movie $favoriteMovie): self
    {
        $this->favoriteMovies->removeElement($favoriteMovie);

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
            $category->setOwner($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getOwner() === $this) {
                $category->setOwner(null);
            }
        }

        return $this;
    }


    /** 
     * @return Collection|Category[]
     */
    public function getFavoriteCategories(): Collection
    {
        return $this->favoriteCategories;
    }

    public function addFavoriteCategory(Category $favoriteCategory): self
    {
        if (!$this->favoriteCategories->contains($favoriteCategory)) {
            $this->favoriteCategories[] = $favoriteCategory;
        }

        return $this;
    }

    public function removeFavoriteCategory(Category $favoriteCategory): self
    {
        $this->favoriteCategories->removeElement($favoriteCategory);

        return $this;
    }

    /**
     * @return Collection|Thematic[]
     */
    public function getFavoriteThematics(): Collection
    {
        return $this->favoriteThematics;
    }

    public function addFavoriteThematic(Thematic $favoriteThematic): self
    {
        if (!$this->favoriteThematics->contains($favoriteThematic)) {
            $this->favoriteThematics[] = $favoriteThematic;
        }

        return $this;
    }

    
    public function removeFavoriteThematic(Thematic $favoriteThematic): self
    {
        $this->favoriteThematics->removeElement($favoriteThematic);

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

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
            $thematic->setOwner($this);
        }

        return $this;
    }

    public function removeThematic(Thematic $thematic): self
    {
        if ($this->thematics->removeElement($thematic)) {
            // set the owning side to null (unless already changed)
            if ($thematic->getOwner() === $this) {
                $thematic->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
            $language->setOwner($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getOwner() === $this) {
                $language->setOwner(null);
            }
        }

        return $this;
    }
}
