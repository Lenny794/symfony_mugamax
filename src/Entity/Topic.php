<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TopicRepository::class)
 */
class Topic
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
    private $subjet;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryTopic::class, inversedBy="topics")
     */
    private $categoryTopic;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="topics")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=TopicComment::class, mappedBy="topic")
     */
    private $topicComments;

    public function __construct()
    {
        $this->topicComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjet(): ?string
    {
        return $this->subjet;
    }

    public function setSubjet(string $subjet): self
    {
        $this->subjet = $subjet;

        return $this;
    }

    public function getCategoryTopic(): ?CategoryTopic
    {
        return $this->categoryTopic;
    }

    public function setCategoryTopic(?CategoryTopic $categoryTopic): self
    {
        $this->categoryTopic = $categoryTopic;

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
            $topicComment->setTopic($this);
        }

        return $this;
    }

    public function removeTopicComment(TopicComment $topicComment): self
    {
        if ($this->topicComments->removeElement($topicComment)) {
            // set the owning side to null (unless already changed)
            if ($topicComment->getTopic() === $this) {
                $topicComment->setTopic(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return "";
    }
}
