<?php

namespace App\Entity;

use App\Repository\CategoryNewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryNewsRepository::class)
 */
class CategoryNews
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ActualityNews::class, mappedBy="categoryNews")
     */
    private $actualityNews;

    public function __construct()
    {
        $this->actualityNews = new ArrayCollection();
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
            $actualityNews->setCategoryNews($this);
        }

        return $this;
    }

    public function removeActualityNews(ActualityNews $actualityNews): self
    {
        if ($this->actualityNews->removeElement($actualityNews)) {
            // set the owning side to null (unless already changed)
            if ($actualityNews->getCategoryNews() === $this) {
                $actualityNews->setCategoryNews(null);
            }
        }

        return $this;
    }
}
