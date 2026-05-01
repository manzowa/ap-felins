<?php

namespace App\Controller\Api;

use App\Repository\CatRepository;
use App\Entity\Cat;
use App\Dto\CatInput;
use App\Dto\CatOutput;
use App\Service\CatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class CatsController extends AbstractController
{
    #[Route('/api/cats', name: 'api_cats', methods: ['GET'])]
    public function index(CatRepository $catRepository): JsonResponse
    {
        $cats = $catRepository->findAll();

        $data = array_map(function (Cat $cat) {
            return [
                'id' => $cat->getId(),
                'name' => $cat->getName(),
                'birthDate' => $cat->getBirthDate()->format('Y-m-d'),
                'breed' => $cat->getBreed() ? $cat->getBreed()->getName() : null,
                'owner' => $cat->getOwner() ? $cat->getOwner()->getName() : null,
            ];
        }, $cats);

        return $this->json($data);
    }

    #[Route('/api/cats', name: 'api_cats_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(validationGroups: ['create'])] CatInput $catInput,
        CatService $catService
    ): JsonResponse 
    {  
        // 1. Création de l'entité via service (logique métier isolée)
        $cat = $catService->createFromInput($catInput);
        // 2. Mapping vers DTO de sortie
        $catOutput = CatOutput::fromEntity($cat);
        // 3. Réponse JSON propre Symfony
        return $this->json($catOutput, 201);
    }


    #[Route('/api/cats/{id}', name: 'api_cats_show', methods: ['GET'])]
    public function show(Cat $cat): JsonResponse
    {
        return $this->json(CatOutput::fromEntity($cat));
    }

    #[Route('/api/cats/{id}', name: 'api_cats_update', methods: ['PUT'])]
    public function update(
        Cat $cat, 
        #[MapRequestPayload] CatInput $catInput,
        CatService $catService
    ): JsonResponse
    {
        $catService->updateFromInput($cat, $catInput);
        return $this->json(CatOutput::fromEntity($cat));
    }

    #[Route('/api/cats/{id}', name: 'api_cats_patch', methods: ['PATCH'])]
    public function patch(
        Cat $cat, 
        #[MapRequestPayload(validationGroups: ['patch'])] CatInput $catInput,
        CatService $catService
    ): JsonResponse
    {
        $catService->updateFromInput($cat, $catInput);
       return $this->json(['status' => 'updated']);
    }

    #[Route('/api/cats/{id}', name: 'api_cats_delete', methods: ['DELETE'])]
    public function delete(Cat $cat, CatService $catService): JsonResponse
    {
        $catService->delete($cat);
        return $this->json(null, 204);
    }
}
