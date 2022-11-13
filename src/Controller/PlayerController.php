<?php

namespace App\Controller;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    /**
     * Route qui renvoit toutes les valeurs
     *
     * @param CardColorRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/player/{id}', name: 'player.getById', methods: ['GET'])]
    public function getById(int $id, PlayerRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $player=$repo->find($id);
        $jsonCardColor = $serializer->serialize($player, 'json');
        return $player ? new JsonResponse($jsonCardColor, Response::HTTP_OK, [], true) : new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}