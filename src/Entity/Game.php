<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $player = null;

    #[ORM\Column]
    private ?int $dealer = null;

    #[ORM\Column(nullable: true)]
    private ?int $scorePlayer = null;

    #[ORM\Column(nullable: true)]
    private ?int $scoreDealer = null;

    #[ORM\Column]
    private ?int $bet = null;

    #[ORM\Column]
    private ?bool $inProgress = null;

    #[ORM\Column(nullable: true)]
    private ?int $winner = null;

    #[ORM\Column(nullable: true)]
    private ?int $result = null;

    

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $deckId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?int
    {
        return $this->player;
    }

    public function setPlayer(int $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getDealer(): ?int
    {
        return $this->dealer;
    }

    public function setDealer(int $dealer): self
    {
        $this->dealer = $dealer;

        return $this;
    }

    public function getScorePlayer(): ?int
    {
        return $this->scorePlayer;
    }

    public function setScorePlayer(int $scorePlayer): self
    {
        $this->scorePlayer = $scorePlayer;

        return $this;
    }

    public function getscoreDealer(): ?int
    {
        return $this->scoreDealer;
    }

    public function setScoreDealer(int $scoreDealer): self
    {
        $this->scoreDealer = $scoreDealer;

        return $this;
    }

    public function getBet(): ?int
    {
        return $this->bet;
    }

    public function setBet(int $bet): self
    {
        $this->bet = $bet;

        return $this;
    }

    public function isInProgress(): ?bool
    {
        return $this->inProgress;
    }

    public function setInProgress(bool $inProgress): self
    {
        $this->inProgress = $inProgress;

        return $this;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function setWinner(?int $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(?int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeckId(): ?int
    {
        return $this->deckId;
    }

    public function setDeckId(int $deckId): self
    {
        $this->deckId = $deckId;

        return $this;
    }
}
