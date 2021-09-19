<?php

namespace App\Entity;

use App\Repository\SettingUserPreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingUserPreferenceRepository::class)
 */
class SettingUserPreference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="settingUserPreferences")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $playstation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $xbox;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nintendo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $steam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $twitch;

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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getPlaystation(): ?string
    {
        return $this->playstation;
    }

    public function setPlaystation(string $playstation): self
    {
        $this->playstation = $playstation;

        return $this;
    }

    public function getXbox(): ?string
    {
        return $this->xbox;
    }

    public function setXbox(string $xbox): self
    {
        $this->xbox = $xbox;

        return $this;
    }

    public function getNintendo(): ?string
    {
        return $this->nintendo;
    }

    public function setNintendo(string $nintendo): self
    {
        $this->nintendo = $nintendo;

        return $this;
    }

    public function getSteam(): ?string
    {
        return $this->steam;
    }

    public function setSteam(string $steam): self
    {
        $this->steam = $steam;

        return $this;
    }

    public function getTwitch(): ?string
    {
        return $this->twitch;
    }

    public function setTwitch(string $twitch): self
    {
        $this->twitch = $twitch;

        return $this;
    }
}
