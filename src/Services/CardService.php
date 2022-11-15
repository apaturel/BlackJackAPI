<?php
namespace App\Services;

use App\Entity\Card;
use App\Entity\Deck;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CardService
{
    public function GenerateShoe(EntityManagerInterface $entityManager)
    {
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
        $entityManager->persist($deck);

        $entityManager->flush();
    }

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