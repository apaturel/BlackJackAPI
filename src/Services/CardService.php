<?php
namespace App\Services;

use App\Repository\CardValueRepository;
use App\Controller\CardValueController;
use Symfony\Component\Serializer\SerializerInterface;

class CardService
{
    public function GenerateShoe()
    {
        //$cardValues=$repo->findAll();
        //dd($cardValues);
        $cardValues = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];
        $cardColors = ["Heart", "Spades", "Diamond", "Club"];
        $indexValue = 0;
        $indexColor = 0;
        $k = 0;
        $nbCards = 52;
        for ($l = 1 ; $l <= 6; $l++) {
            for ($k; $k <= $l*$nbCards-1 ; $k++ ){
                $deck[$k] = [
                    'value' => $cardValues[$indexValue],
                    'color' => $cardColors[$indexColor],
                ];
                $indexColor++;
                if (($k+1)%4 == 0 && $k!=0) {
                    $indexValue++;
                    $indexColor = 0;
                }
            }
            $indexValue = 0;
            $indexColor = 0;
        }
        shuffle($deck);
        $nbLeftCards = 311;
        array_slice($deck, 5, $nbLeftCards);
        $nbLeftCards -= 5;
        return[$deck, $nbLeftCards];
    }

    public function HitACard($deck, $nbLeftCards){
        $card = $deck[0];
        $deck = array_slice($deck, 10, $nbLeftCards);
        $nbLeftCards -= 1;
        return [$card, $deck, $nbLeftCards];
    }
}