<?php
namespace App\Services;

use App\Entity\Deck;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DeckService
{
    public function LinkDeckToGame(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, DeckService $deckService, $gameId)
    {
        $deckRepository = $doctrine->getRepository(Deck::class);
        $deck = $deckRepository->findOneBy(array('isPlayable' => true));

        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);
        
        if ($deck !== null){
            $game->setDeck($deck->getId());
        }else{
            $deckService->GenerateShoe($entityManager, $doctrine, $gameId);
            $deckRepository = $doctrine->getRepository(Deck::class);
            $deck = $deckRepository->findOneBy([], ['id' => 'desc']);
            $game->setDeck($deck->getId());
        }

        $entityManager->persist($game);

        $entityManager->flush();
        // if ($deck->getLeftCards() < 50){
        //     $deck->setIsPlayable(false);
        //     $deckService->GenerateShoe($entityManager);

        //     $deckRepository = $doctrine->getRepository(Deck::class);
        //     $deck = $deckRepository->findOneBy([], ['id' => 'desc']);

        //     $game->setDeckId($deck->getId());
        // }else{
        //     $game->setDeckId($deck->getId());
        // }
    }

    public function GenerateShoe(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $gameId)
    {
        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);

        $curlValues = curl_init();
        curl_setopt($curlValues, CURLOPT_URL, "http://localhost:8000/api/card/value");
        curl_setopt($curlValues, CURLOPT_RETURNTRANSFER, true);
        $cardValues = curl_exec($curlValues);
        curl_close($curlValues);
        $cardValues = json_decode($cardValues, true);
        
        $curlColors = curl_init();
        curl_setopt($curlColors, CURLOPT_URL, "http://localhost:8000/api/card/color");
        curl_setopt($curlColors, CURLOPT_RETURNTRANSFER, true);
        $cardColors = curl_exec($curlColors);
        curl_close($curlColors);
        $cardColors = json_decode($cardColors, true);
        $k = 0;

        for ($l = 1 ; $l <= 6; $l++) {
            foreach ($cardValues as $cardValue){
                foreach ($cardColors as $cardColor){
                    $shoe[$k] = [
                        'value' => $cardValue['value'],
                        'color' => $cardColor['color'],
                    ];
                    $k++;
                }
            }
        }
        
        shuffle($shoe);
        $nbLeftCards = 311;
        array_slice($shoe, 5, $nbLeftCards);
        $nbLeftCards -= 5;

        $deck = new Deck();
        $deck->setShoe($shoe);
        $deck->setLeftCards($nbLeftCards);
        $deck->setIsPlayable(true);
        $entityManager->persist($deck);

        $entityManager->flush();
    }

}