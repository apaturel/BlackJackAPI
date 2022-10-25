<?php
namespace App\Services;

class ScoreService
{
    public function CalculateScore($score, $scoreBis, $cards)
    {
        foreach ($cards as $card) {
                switch ($card["value"]) {
                    case "2":
                        $score += 2;
                        $scoreBis += 2;
                        break;
                    case "3":
                        $score += 3;
                        $scoreBis += 3;
                        break;
                    case "4":
                        $score += 4;
                        $scoreBis += 4;
                        break;
                    case "5":
                        $score += 5;
                        $scoreBis += 5;
                        break;
                    case "6":
                        $score += 6;
                        $scoreBis += 6;
                        break;
                    case "7":
                        $score += 7;
                        $scoreBis += 7;
                        break;
                    case "8":
                        $score += 8;
                        $scoreBis += 8;
                        break;
                    case "9":
                        $score += 9;
                        $scoreBis += 9;
                        break;
                    case "10":
                        $score += 10;
                        $scoreBis += 10;
                        break;
                    case "J":
                        $score += 10;
                        $scoreBis += 10;
                        break;
                    case "Q":
                        $score += 10;
                        $scoreBis += 10;
                        break;
                    case "K":
                        $score += 10;
                        $scoreBis += 10;
                        break;
                    case "A":
                        $score += 11;
                        $scoreBis += 1;
                        break;
                } 
        }
        return [$score, $scoreBis];
    }
}