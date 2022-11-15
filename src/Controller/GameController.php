<?php

namespace App\Controller;

use App\Services\CardService;
use App\Services\GameService;
use App\Services\ScoreService;
use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Score;

use App\Entity\Deck;
use App\Repository\DeckRepository;
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
        ScoreService $scoreService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        int $gameId
        ): JsonResponse
    {
        $dealerId = 1;

        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);

        $cardRepository = $doctrine->getRepository(Card::class);
        $cards = $cardRepository->findBy(array('gameId' => $gameId));

        $i = 0;
        $j = 0;
        $playerCard = [];
        $dealerCard = [];

        foreach ($cards as $card){
            if ($card->getPlayerId() !== 1){
                $playerCard[$i] = $card;
                $i++;
            }else{
                $dealerCard[$j] = $card;
                $j++;
            }
        }

        $playerId = $game->getPlayer();

        $scoreService->CalculateScore($entityManager, $doctrine, $gameId, $playerId);

        $scoreService->CalculateScore($entityManager, $doctrine, $gameId, $dealerId);

        //TODO : Vérif des scores
        // $game->setScorePlayer();
        // $game->setScoreDealer();

        $game->setInProgress(true);
        
        $entityManager->persist($game);

        $entityManager->flush();

        $jsonInit = $serializer->serialize($game, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/api/game/{gameId}/hit', name: 'app_game_hit')]
    public function hit(
        ManagerRegistry $doctrine,
        ScoreService $scoreService,
        CardService $cardService,
        GameService $gameService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        int $gameId
        ): JsonResponse
    {
        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);

        $deckId = $game->getDeckId();
        $playerId = $game->getPlayer();

        $cardService->HitACard($entityManager, $doctrine, $deckId, $playerId);

        $jsonInit = $serializer->serialize($gameId, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/api/game/{gameId}/hit', name: 'app_game_double')]
    public function double(
        ManagerRegistry $doctrine,
        ScoreService $scoreService,
        CardService $cardService,
        GameService $gameService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        int $gameId
        ): JsonResponse
    {
        $gameRepository = $doctrine->getRepository(Game::class);
        $game = $gameRepository->find($gameId);

        $deckId = $game->getDeckId();
        $playerId = $game->getPlayer();

        $cardService->HitACard($entityManager, $doctrine, $deckId, $playerId);

        //TODO : FIN DE GAME ( à faire après la gestion de partie)

        $jsonInit = $serializer->serialize($gameId, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/api/game/{gameId}/splitter', name: 'app_game_splitter')]
    public function splitter(
        ManagerRegistry $doctrine,
        ScoreService $scoreService,
        CardService $cardService,
        GameService $gameService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        int $gameId
        ): JsonResponse
    {
        

        //TODO :

        $jsonInit = $serializer->serialize($gameId, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }

    #[Route('/test', name: 'app_test')]
    public function test(
        ManagerRegistry $doctrine,
        GameService $gameService,
        CardService $cardService,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $deckRepository = $doctrine->getRepository(Deck::class);
        $deck = $deckRepository->findOneBy(array('isPlayable' => true));
        $shoe = $deck->getShoe();
        $nbLeftCards = $deck->getLeftCards();
        $newShoe = array_slice($shoe, 1, $nbLeftCards);

        $jsonInit = $serializer->serialize($newShoe, 'json', []);
        return new JsonResponse($jsonInit, Response::HTTP_OK, [], true);
    }
} 