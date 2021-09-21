<?php

namespace App\Entity;

use App\Repository\ActualityCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActualityCommentRepository::class)
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
}
