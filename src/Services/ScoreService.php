<?php
namespace App\Services;

use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ScoreService
{
    public function CalculateScore(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $gameId, $playerId)
    {
        $scoreRepository = $doctrine->getRepository(Score::class);
        $scores = $scoreRepository->findBy(array('gameId' => $gameId));
        if ($scores !== null){
            foreach ($scores as $score) {
                if ($score->getPlayerId() === $playerId){
                    $newScore = $score->getScore();
                    $newScoreBis = $score->getScoreBis();
                }
            }
        }else{
            $score = new Score();
            $newScore = 0;
            $newScoreBis = 0;
        }

        $cardRepository = $doctrine->getRepository(Card::class);
        $cards = $cardRepository->findBy(array('gameId' => $gameId));

        $i = 0;
        foreach ($cards as $card){
            if ($card->getPlayerId() === $playerId){
                $playerCard[$i] = $card;
                $i++;
            }
        }

        foreach ($cards as $card) {
                switch ($card["value"]) {
                    case "2":
                        $newScore += 2;
                        $newScoreBis += 2;
                        break;
                    case "3":
                        $newScore += 3;
                        $newScoreBis += 3;
                        break;
                    case "4":
                        $newScore += 4;
                        $newScoreBis += 4;
                        break;
                    case "5":
                        $newScore += 5;
                        $newScoreBis += 5;
                        break;
                    case "6":
                        $newScore += 6;
                        $newScoreBis += 6;
                        break;
                    case "7":
                        $newScore += 7;
                        $newScoreBis += 7;
                        break;
                    case "8":
                        $newScore += 8;
                        $newScoreBis += 8;
                        break;
                    case "9":
                        $newScore += 9;
                        $newScoreBis += 9;
                        break;
                    case "10":
                        $newScore += 10;
                        $newScoreBis += 10;
                        break;
                    case "J":
                        $newScore += 10;
                        $newScoreBis += 10;
                        break;
                    case "Q":
                        $newScore += 10;
                        $newScoreBis += 10;
                        break;
                    case "K":
                        $newScore += 10;
                        $newScoreBis += 10;
                        break;
                    case "A":
                        $newScore += 11;
                        $newScoreBis += 1;
                        break;
                } 
        }
        if ($newScore <= 21) {
            $score->setBusted(false);
        } elseif ($newScore > 21 && $newScoreBis <= 21){
            $score->setBusted(false);
            $newScore = $newScoreBis;
        } else {
            $score->setBusted(true);
        }
        $score->setScore($newScore);
        $score->setScoreBis($newScoreBis);
        $entityManager->persist($score);

        $entityManager->flush();
    }
}