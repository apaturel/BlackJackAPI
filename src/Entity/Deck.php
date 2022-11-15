<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $shoe = [];

    #[ORM\Column]
    private ?int $leftCards = null;

    #[ORM\Column]
    private ?bool $isPlayable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoe(): array
    {
        return $this->shoe;
    }

    public function setShoe(array $shoe): self
    {
        $this->shoe = $shoe;

        return $this;
    }

    public function getLeftCards(): ?int
    {
        return $this->leftCards;
    }

    public function setLeftCards(int $leftCards): self
    {
        $this->leftCards = $leftCards;

        return $this;
    }

    public function isIsPlayable(): ?bool
    {
        return $this->isPlayable;
    }

    public function setIsPlayable(bool $isPlayable): self
    {
        $this->isPlayable = $isPlayable;

        return $this;
    }
}
