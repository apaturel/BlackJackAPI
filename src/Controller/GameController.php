<?php

namespace App\Controller;

use App\Services\CardService;
use App\Services\GameService;
use App\Services\ScoreService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/api/game/start', name: 'app_game_start')]
    public function startGame(
        GameService $gameService,
        CardService $cardService,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $init = $gameService->GenerateStartingHands($cardService);
        $jsonInit = $serializer->serialize($init, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/test', name: 'test')]
    public function test(
        GameService $gameService,
        ScoreService $scoreService,
        CardService $cardService,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $score = 0;
        $scoreBis = 0;
        $start = $gameService->GenerateStartingHands($cardService);
        $init = $scoreService->CalculateScore($score, $scoreBis, $start["playerCard"]);
        $jsonInit = $serializer->serialize([$start, $init], 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }
}