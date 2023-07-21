<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/category',  methods:['GET'])]
    public function getCategory(): JsonResponse
    {
        $categories = $this->entityManager->getRepository(Categories::class)->findAll();

        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/category', methods:['POST'])]
    public function savecategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category = new Categories();
        $category->setName($data['name']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Category saved successfully'], Response::HTTP_CREATED);
    }
}

