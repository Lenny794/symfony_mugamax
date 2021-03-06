<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo est déja utilisé")
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
     * @Assert\NotBlank(message="Vous devez ajouter un pseudo")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez choisir un genre")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner un prénom")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner un nom")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner une adresse email")
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Vous devez renseigner une date de naissance")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner un pays")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=ActualityNews::class, mappedBy="user")
     */
    private $actualityNews;

    /**
     * @ORM\OneToMany(targetEntity=Topic::class, mappedBy="user")
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity=TopicComment::class, mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)))
     */
    private $topicComments;

    /**
     * @ORM\OneToMany(targetEntity=ActualityComment::class, mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)))
     */
    private $actualityComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar_user;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="user")
     */
    private $videos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->actualityNews = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->topicComments = new ArrayCollection();
        $this->settingUserPreferences = new ArrayCollection();
        $this->actualityComments = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->pseudo;
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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|ActualityNews[]
     */
    public function getActualityNews(): Collection
    {
        return $this->actualityNews;
    }

    public function addActualityNews(ActualityNews $actualityNews): self
    {
        if (!$this->actualityNews->contains($actualityNews)) {
            $this->actualityNews[] = $actualityNews;
            $actualityNews->setUser($this);
        }

        return $this;
    }

    public function removeActualityNews(ActualityNews $actualityNews): self
    {
        if ($this->actualityNews->removeElement($actualityNews)) {
            // set the owning side to null (unless already changed)
            if ($actualityNews->getUser() === $this) {
                $actualityNews->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TopicComment[]
     */
    public function getTopicComments(): Collection
    {
        return $this->topicComments;
    }

    public function addTopicComment(TopicComment $topicComment): self
    {
        if (!$this->topicComments->contains($topicComment)) {
            $this->topicComments[] = $topicComment;
            $topicComment->setUser($this);
        }

        return $this;
    }

    public function removeTopicComment(TopicComment $topicComment): self
    {
        if ($this->topicComments->removeElement($topicComment)) {
            // set the owning side to null (unless already changed)
            if ($topicComment->getUser() === $this) {
                $topicComment->setUser(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->pseudo;
    }

    /**
     * @return Collection|SettingUserPreference[]
     */
    public function getSettingUserPreferences(): Collection
    {
        return $this->settingUserPreferences;
    }

    /**
     * @return Collection|ActualityComment[]
     */
    public function getActualityComments(): Collection
    {
        return $this->actualityComments;
    }

    public function addActualityComment(ActualityComment $actualityComment): self
    {
        if (!$this->actualityComments->contains($actualityComment)) {
            $this->actualityComments[] = $actualityComment;
            $actualityComment->setUser($this);
        }

        return $this;
    }

    public function removeActualityComment(ActualityComment $actualityComment): self
    {
        if ($this->actualityComments->removeElement($actualityComment)) {
            // set the owning side to null (unless already changed)
            if ($actualityComment->getUser() === $this) {
                $actualityComment->setUser(null);
            }
        }

        return $this;
    }

    public function getAvatarUser(): ?string
    {
        return $this->avatar_user;
    }

    public function setAvatarUser(?string $avatar_user): self
    {
        $this->avatar_user = $avatar_user;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

        return $this;
    }
    
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
