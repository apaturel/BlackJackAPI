<?php

namespace App\Controller;

use App\Entity\CardColor;
use App\Repository\CardColorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CardColorController extends AbstractController
{
    /**
     * Route qui renvoit une valeur
     *
     * @param CardColorRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/card/color/{id}', name: 'cardColor.get', methods: ['GET'])]
    public function getCardColor(int $id, CardColorRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $cardColor=$repo->find($id);
        $jsonCardColor = $serializer->serialize($cardColor, 'json');

        return $cardColor ? new JsonResponse($jsonCardColor, Response::HTTP_OK, [], true) : new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Route qui renvoit toutes les valeurs
     *
     * @param CardColorRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/card/color', name: 'cardColor.getAll')]
    public function getAllCardColor(CardColorRepository $repo, SerializerInterface $serializer): JsonResponse
    {
        $cardColors=$repo->findAll();
        $jsonCardColor = $serializer->serialize($cardColors, 'json', ["groups",  "getAllCardColors"]);
        return new JsonResponse($jsonCardColor, Response::HTTP_OK, [], true);
    }
}