<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActualityCommentRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;


/**
 * @ORM\Entity(repositoryClass=ActualityCommentRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ActualityComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="actualityComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ActualityNews::class, inversedBy="actualityComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $actualityNews;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getActualityNews(): ?ActualityNews
    {
        return $this->actualityNews;
    }

    public function setActualityNews(?ActualityNews $actualityNews): self
    {
        $this->actualityNews = $actualityNews;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
