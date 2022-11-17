<?php
namespace App\Services;

use App\Entity\Card;
use App\Entity\Deck;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CardService
{
    public function HitACard(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $deckId, int $playerId){

        $deckRepository = $doctrine->getRepository(Deck::class);
        $deck = $deckRepository->find($deckId);

        $shoe = $deck->getShoe();
        $nbLeftCards = $deck->getLeftCards();

        $card = $shoe[0];

        switch ($card["value"]) {
            case "2":
                $idValue = 12;
                break;
            case "3":
                $idValue = 11;
                break;
            case "4":
                $idValue = 10;
                break;
            case "5":
                $idValue = 9;
                break;
            case "6":
                $idValue = 8;
                break;
            case "7":
                $idValue = 7;
                break;
            case "8":
                $idValue = 6;
                break;
            case "9":
                $idValue = 5;
                break;
            case "10":
                $idValue = 4;
                break;
            case "J":
                $idValue = 3;
                break;
            case "Q":
                $idValue = 2;
                break;
            case "K":
                $idValue = 1;
                break;
            case "A":
                $idValue = 0;
                break;
        }

        switch ($card["color"]) {
            case "heart":
                $idColor = 0;
                break;
            case "spade":
                $idColor = 1;
                break;
            case "diamond":
                $idColor = 2;
                break;
            case "club":
                $idColor = 3;
                break;
        }

        $newShoe = array_slice($shoe, 1, $nbLeftCards);
        $nbLeftCards -= 1;

        $deck->setShoe($newShoe);
        $deck->setLeftCards($nbLeftCards);
        $entityManager->persist($deck);

        $cards = new Card();
        $cards->setCardValueId($idValue);
        $cards->setCardColorId($idColor);
        $cards->setPlayerId($playerId);
        $entityManager->persist($cards);

        $entityManager->flush();
    }
}