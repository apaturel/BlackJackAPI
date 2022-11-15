<?php
namespace App\Services;

use App\Entity\Deck;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DeckService
{
    public function IsPlayable(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, CardService $cardService, $gameId)
    {
        $deckRepository = $doctrine->getRepository(Deck::class);
        $deck = $deckRepository->findOneBy(array('isPlayable' => true));

        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);
        
        if ($deck->getLeftCards() < 50){
            $deck->setIsPlayable(false);
            $cardService->GenerateShoe($entityManager);

            $deckRepository = $doctrine->getRepository(Deck::class);
            $deck = $deckRepository->findOneBy([], ['id' => 'desc']);

            $game->setDeckId($deck->getId());
        }else{
            $game->setDeckId($deck->getId());
        }
    }


}