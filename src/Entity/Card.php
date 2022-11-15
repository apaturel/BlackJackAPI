<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cardValueId = null;

    #[ORM\Column]
    private ?int $cardColorId = null;

    #[ORM\Column]
    private ?int $playerId = null;

    #[ORM\Column]
    private ?int $gameId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardValueId(): ?int
    {
        return $this->cardValueId;
    }

    public function setCardValueId(int $cardValueId): self
    {
        $this->cardValueId = $cardValueId;

        return $this;
    }

    public function getCardColorId(): ?int
    {
        return $this->cardColorId;
    }

    public function setCardColorId(int $cardColorId): self
    {
        $this->cardColorId = $cardColorId;

        return $this;
    }

    public function getPlayerId(): ?int
    {
        return $this->playerId;
    }

    public function setPlayerId(int $playerId): self
    {
        $this->playerId = $playerId;

        return $this;
    }

    public function getGameId(): ?int
    {
        return $this->gameId;
    }

    public function setGameId(int $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }
}
