<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/')]
    public function index()
    {
        return new JsonResponse(['message' => 'test api url']); 
    }

    #[Route('/api/products',  methods:['GET'])]
    public function getProducts(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Products::class)->findAll();

        $data = [];
        foreach ($products as $product) {
            $category = $this->entityManager->getRepository(Categories::class)->find($product->getId())->getName();
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'image' => $product->getImage(),
                'price' => $product->getPrice(),
                'category' => $category,
                'description' => $product->getDescription()
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/products/{id}',  methods:['GET'])]
    public function getProductById($id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Products::class)->find(1);
        $category = $this->entityManager->getRepository(Categories::class)->find($product->getId())->getName();
        $data = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'image' => $product->getImage(),
            'price' => $product->getPrice(),
            'category' => $category,
            'description' => $product->getDescription()
        ];

        return new JsonResponse($data);
    }

    #[Route('/api/products', methods:['POST'])]
    public function saveProduct(Request $request): JsonResponse
    {
        // Get the uploaded file
        $file = $request->files->get('image');

        // Generate a unique filename
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        // Save data to DB
        $product = new Products();
        $product->setName($request->request->get('name'));
        $product->setimage($filename);
        $product->setprice($request->request->get('price'));
        $product->setCategory($request->request->get('category'));
        $product->setDescription($request->request->get('description'));

        // Move the file to the desired directory
        $file->move($this->getParameter('upload_directory'),$filename);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Product saved successfully'], Response::HTTP_CREATED);
    }
}

