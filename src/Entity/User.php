<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column(length: 100, unique: true)]
    private ?string $login = null;

    #[ORM\Column(length: 25)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column]
    private ?bool $isBlocked = null;

    #[ORM\OneToOne(mappedBy: 'userClient', cascade: ['persist', 'remove'])]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   

   

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setBlocked(bool $isBlocked): static
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        // unset the owning side of the relation if necessary
        if ($client === null && $this->client !== null) {
            $this->client->setUserClient(null);
        }

        // set the owning side of the relation if necessary
        if ($client !== null && $client->getUserClient() !== $this) {
            $client->setUserClient($this);
        }

        $this->client = $client;

        return $this;
    }
}