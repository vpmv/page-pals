<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $Key = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(nullable: true)]
    private ?int $Age = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateOfBirth = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateOfDeath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    public static function fromJSON(array $author): Author {
        $a = new Author();
        $a->setKey($author['key']);
        $a->setName($author['name']);
        $a->setDateOfBirth($author['dateOfBirth'] ?? null);
        $a->setDateOfDeath($author['dateOfDeath'] ?? null);
        $a->setDescription($author['description'] ?? '');
        $a->setAge();

        return $a;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->Key;
    }

    public function setKey(string $Key): static
    {
        $this->Key = $Key;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(): static
    {
        if ($this->DateOfBirth) {
            $now = new \DateTime();
            if ($this->DateOfDeath) {
                $now = $this->DateOfDeath;
            }
            $this->Age = $this->DateOfBirth->diff($now)->y;
        }

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->DateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $DateOfBirth): static
    {
        $this->DateOfBirth = $DateOfBirth;

        return $this;
    }

    public function getDateOfDeath(): ?\DateTimeInterface
    {
        return $this->DateOfDeath;
    }

    public function setDateOfDeath(?\DateTimeInterface $DateOfDeath): static
    {
        $this->DateOfDeath = $DateOfDeath;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }
}
