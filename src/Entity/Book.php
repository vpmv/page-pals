<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $key = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $authorKey = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $authors = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getKey(): ?string {
        return $this->key;
    }

    public function setKey(string $key): static {
        $this->key = $key;

        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): static {
        $this->title = $title;

        return $this;
    }

    public function getAuthorKey(): ?array {
        return $this->authorKey;
    }

    public function setAuthorKey(?array $authorKey): static {
        $this->authorKey = $authorKey;

        return $this;
    }

    public function getAuthors(): ?array {
        return $this->authors;
    }

    public function setAuthors(?array $authors): static {
        $this->authors = $authors;

        return $this;
    }

    public function getSummary(): ?string {
        return $this->summary;
    }

    public function setSummary(?string $summary): static {
        $this->summary = $summary;

        return $this;
    }

    public function getRating(): ?float {
        return $this->rating;
    }

    public function setRating(?float $rating): static {
        $this->rating = $rating;

        return $this;
    }

    public static function fromJSON(array $data): Book {
        $authors = [];
        foreach ($data["authors"] as $author) {
            $authors[] = Author::fromJSON($author);
        }

        $b = new Book();
        $b->setKey($data['key']);
        $b->setTitle($data['title']);
        $b->setSummary($data['summary'] ?? null);
        $b->setRating($data['rating'] ?? 0);
        $b->setAuthorKey($data['author_key'] ?? []);
        $b->setAuthors($authors);

        return $b;
    }
}
