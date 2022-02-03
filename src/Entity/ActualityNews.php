<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActualityNewsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass=ActualityNewsRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ActualityNews
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryNews::class, inversedBy="actualityNews")
     */
    private $categoryNews;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="actualityNews")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ActualityComment::class, mappedBy="actualityNews", cascade={"persist", "remove"}, orphanRemoval=true))
     */
    private $actualityComments;

    public function __construct()
    {
        $this->actualityComments = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if(empty($this->createdAt))
        {
            $this->createdAt = new DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategoryNews(): ?CategoryNews
    {
        return $this->categoryNews;
    }

    public function setCategoryNews(?CategoryNews $categoryNews): self
    {
        $this->categoryNews = $categoryNews;

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
            $actualityComment->setActualityNews($this);
        }

        return $this;
    }

    public function removeActualityComment(ActualityComment $actualityComment): self
    {
        if ($this->actualityComments->removeElement($actualityComment)) {
            // set the owning side to null (unless already changed)
            if ($actualityComment->getActualityNews() === $this) {
                $actualityComment->setActualityNews(null);
            }
        }

        return $this;
    }
}
