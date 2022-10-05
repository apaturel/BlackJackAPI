<?php
namespace App\Services;

use App\Services\CardService;

class GameService
{
    public function GenerateStartingHands(CardService $cardService)
    {
        $shoe = $cardService->GenerateShoe();

        $playerCard1 = $cardService->HitACard($shoe[0], $shoe[1]);
        $croupierCard1 = $cardService->HitACard($playerCard1[1], $playerCard1[2]);
        $playerCard2 = $cardService->HitACard($croupierCard1[1], $croupierCard1[2]);
        $croupierCard2 = $cardService->HitACard($playerCard2[1], $playerCard2[2]);
        return ['playerCard' => [$playerCard1[0], $playerCard2[0]], 'croupierCard'  => [$croupierCard1[0], $croupierCard2[0]]];
    }
}