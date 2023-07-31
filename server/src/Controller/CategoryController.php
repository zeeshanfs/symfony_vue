<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\ApiController;
use App\Entity\Categories;

class CategoryController extends AbstractController
{
    private $entityManager;
    private $apiManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->apiManager = new ApiController();
    }

    #[Route('/api/category',  methods:['GET'])]
    public function getCategory()
    {
        $categories = $this->entityManager->getRepository(Categories::class)->findAll();

        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return $this->apiManager->respond($data);
    }

    #[Route('/api/category', methods:['POST'])]
    public function savecategory(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $category = new Categories();
        $category->setName($data['name']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->apiManager->respond(['message' => 'Category saved successfully']);
    }
}

