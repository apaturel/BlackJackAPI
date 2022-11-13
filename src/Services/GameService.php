<?php
namespace App\Services;

use App\Services\CardService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class GameService
{
    public function GenerateStartingHands(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, CardService $cardService, $deckId, $playerId)
    {

        $cardService->GenerateShoe($entityManager);

        $cardService->HitACard($entityManager, $doctrine, $deckId, $playerId);
        // $cardService->HitACard($entityManager, $doctrine, $deckId, 0);
        // $cardService->HitACard($entityManager, $doctrine, $deckId, $playerId);
        // $cardService->HitACard($entityManager, $doctrine, $deckId, 0);
    }
}