<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $surname = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 100)]
    private ?string $adresse = null;

    #[ORM\Column(type: 'datetime')]   
    private ?\DateTimeInterface  $createAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    private ?User $userClient = null;

    /**
     * @var Collection<int, Dette>
     */
    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $dettes;

    public function __construct()
    {
        $this->dettes = new ArrayCollection();
        $this->createAt = new \DateTime(); // Définit la date de création à l'heure actuelle
        $this->updateAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getUserClient(): ?User
    {
        return $this->userClient;
    }

    public function setUserClient(?User $userClient): static
    {
        $this->userClient = $userClient;

        return $this;
    }

    /**
     * @return Collection<int, Dette>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dette $dette): static
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes->add($dette);
            $dette->setClient($this);
        }

        return $this;
    }

    public function removeDette(Dette $dette): static
    {
        if ($this->dettes->removeElement($dette)) {
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

        return $this;
    }  
    
    public function __toString(): string 
    {
        return $this->surname ?? ''; // Retourne le nom ou une chaîne vide si null
    }
}
