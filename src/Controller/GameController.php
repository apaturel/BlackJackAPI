<?php

namespace App\Controller;

use App\Services\CardService;
use App\Services\GameService;
use App\Services\ScoreService;
use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Score;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class GameController extends AbstractController
{

    #[Route('/api/game/init/{playerName}/{bet}', name: 'app_game_init_playerName_bet', methods: ['POST'])]
    public function initGame(
        String $playerName,
        int $bet,
        ManagerRegistry $doctrine,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
        ): JsonResponse
    {
        $newGame = new Game();
        $playerRepository = $doctrine->getRepository(Player::class);
        $gameRepository = $doctrine->getRepository(Game::class);

        $playerExist = $playerRepository->findOneBy(['name' => $playerName]);
        $gamesInProgress = $gameRepository->findBy(array('inProgress' => 1));

        if ($playerExist != null) {
            $player = $playerExist;
            $playerId = $player->getId();
            $gameExist = null;
            foreach ($gamesInProgress as $gameInProgress) {
                if ( $gameInProgress->getPlayer() === $playerId){
                    $gameExist = $gameInProgress;
                }
            }
        } else {
            $player = new Player();
            $player->setName($playerName);
            $entityManager->persist($player);
            $entityManager->flush();
        }

        if ($gameExist !== null) {
            $game = $gameExist;
        } else {
            $game = $newGame;
            $newGame->setPlayer($player->getId());
            $newGame->setDealer(1);
            $newGame->setBet((int)$bet);
            $newGame->setInProgress(true);
            $newGame->setStatus(true);
            $entityManager->persist($newGame);
            $entityManager->flush();
        }

        $jsonInit = $serializer->serialize($game, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/api/game/start/{gameId}', name: 'app_game_start')]
    public function startGame(
        ManagerRegistry $doctrine,
        GameService $gameService,
        ScoreService $scoreService,
        CardService $cardService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        int $gameId
        ): JsonResponse
    {
        $scoreBase = 0;
        $scoreBisBase = 0;

        $deckId = 0;


        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);

        $playerId = $game->getPlayer();

        $start = $gameService->GenerateStartingHands($entityManager, $doctrine, $cardService, $deckId, $playerId);

        $playerCardsSum = $scoreService->CalculateScore($scoreBase, $scoreBisBase, $start["playerCard"]);
        $playerScore = $playerCardsSum[0];
        $playerScoreBis = $playerCardsSum[1];

        $dealerCardsSum = $scoreService->CalculateScore($scoreBase, $scoreBisBase, $start["dealerCard"]);
        $dealerScore = $dealerCardsSum[0];
        $dealerScoreBis = $dealerCardsSum[1];

        $playerScoreSave = new Score();
        if ($playerScore <= 21) {
            $playerScoreSave->setBusted(false);
        } elseif ($playerScoreBis <= 21){
            $playerScoreSave->setBusted(false);
            $playerScore = $playerScoreBis;
        } else {
            $playerScoreSave->setBusted(true);
        }
        $playerScoreSave->setScore($playerScore);
        $playerScoreSave->setScoreBis($playerScoreBis);
        $entityManager->persist($playerScoreSave);

        $dealerScoreSave = new Score();
        if ($playerScore <= 21) {
            $dealerScoreSave->setBusted(false);
        } else if ($playerScoreBis <= 21){
            $dealerScoreSave->setBusted(false);
            $playerScore = $playerScoreBis;
        } else {
            $dealerScoreSave->setBusted(true);
        }
        $dealerScoreSave->setScore($dealerScore);
        $dealerScoreSave->setScoreBis($dealerScoreBis);
        $entityManager->persist($dealerScoreSave);

        $entityManager->flush();

        $game->setInProgress(true);
        $game->setScorePlayer($playerScoreSave->getId());
        $game->setScoreDealer($dealerScoreSave->getId());
        $entityManager->persist($game);

        $entityManager->flush();

        $jsonInit = $serializer->serialize([$start, [$playerCardsSum, $dealerCardsSum]], 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/test', name: 'app_test')]
    public function test(
        ManagerRegistry $doctrine,
        GameService $gameService,
        ScoreService $scoreService,
        CardService $cardService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
        ): JsonResponse
    {
        
        //$start = $gameService->GenerateStartingHands($entityManager, $doctrine, $cardService, 0, 19);

        $deckRepository = $doctrine->getRepository(Deck::class);
        $deck = $deckRepository->find(0);

        $shoe = $deck->getShoe();

        $jsonInit = $serializer->serialize($shoe, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }
} 