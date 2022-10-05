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
    private ?int $scorePlayerA = null;

    #[ORM\Column]
    private ?int $scorePlayerB = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScorePlayerA(): ?int
    {
        return $this->scorePlayerA;
    }

    public function setScorePlayerA(int $scorePlayerA): self
    {
        $this->scorePlayerA = $scorePlayerA;

        return $this;
    }

    public function getScorePlayerB(): ?int
    {
        return $this->scorePlayerB;
    }

    public function setScorePlayerB(int $scorePlayerB): self
    {
        $this->scorePlayerB = $scorePlayerB;

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
}
