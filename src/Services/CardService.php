<?php
namespace App\Services;

class CardService
{
    public function GenerateShoe()
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
                    $deck[$k] = [
                        'value' => $cardValue['value'],
                        'color' => $cardColor['color'],
                    ];
                    $k++;
                }
            }
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

    public function ShowPlayerHand($hands){
        return $hands[0];
    }

    public function ShowCroupierHand($hands){
        return $hands[1];
    }
}