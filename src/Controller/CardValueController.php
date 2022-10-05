<?php

namespace App\Controller;

use App\Entity\CardValue;
use App\Repository\CardValueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CardValueController extends AbstractController
{
    #[Route('/card/value', name: 'app_card_value')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/ControllerCardValueController.php',
        ]);
    }

    /**
     * Route qui renvoit toutes les valeurs
     *
     * @param CardValueRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/card/value', name: 'cardValue.getAll')]
    public function getAllCardValue(CardValueRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $cardValues=$repo->findAll();
        $jsonCardValue = $serializer->serialize($cardValues, 'json', ["groups",  "getAllCardValues"]);
        return new JsonResponse($jsonCardValue, Response::HTTP_OK, [], true);
    }
    /**
     * Route qui renvoit une valeur
     *
     * @param CardValueRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/card/value/{id}', name: 'cardValue.get', methods: ['GET'])]
    public function getCardValue(int $id, CardValueRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $cardValue=$repo->find($id);
        $jsonCardValue = $serializer->serialize($cardValue, 'json');

        return $cardValue ? new JsonResponse($jsonCardValue, Response::HTTP_OK, [], true) : new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

     /**
     * Route qui renvoit une valeur
     *
     * @param CardValueRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
    #[Route('/api/card/value/{idCardValue}', name: 'cardValue.get', methods: ['GET'])]
    #[ParamConverter("cardValue", options:["id" => "idCardValue"])]
    public function getCardValue(CardValue $cardValue, SerializerInterface $serializer): JsonResponse
    {
        $jsonCardValue = $serializer->serialize($cardValue, 'json');
        return new JsonResponse($jsonCardValue, Response::HTTP_OK, ['accept' => 'json'], true);
    }

      */
}