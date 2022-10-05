<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(nullable: true)]
    private ?int $scoreAs = null;

    #[ORM\Column]
    private ?bool $busted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getScoreAs(): ?int
    {
        return $this->scoreAs;
    }

    public function setScoreAs(?int $scoreAs): self
    {
        $this->scoreAs = $scoreAs;

        return $this;
    }

    public function isBusted(): ?bool
    {
        return $this->busted;
    }

    public function setBusted(bool $busted): self
    {
        $this->busted = $busted;

        return $this;
    }
}
