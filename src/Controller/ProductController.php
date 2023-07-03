<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function index(ProductRepository $ProductRepository): JsonResponse
    {
        return $this->json([
            'data' => $ProductRepository->findAll(),
        ]);
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(Request $request, ProductRepository $ProductRepository): JsonResponse
    {   
        if($request->headers->get('Content-Type') == 'application/json')
        {
            $data = $request->toArray();
        } else 
        {
            $data = $request->request->all();
        }
        

        $product = new Product();
        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setPricePromotion($data['pricePromotion']);
        $product->setTax($data['tax']);
        $product->setPromotion($data['promotion']);
        $product->setActive($data['active']);
        $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $ProductRepository->save($product, true);


        return $this->json([
            'message' => 'Catalago created successfully',
            'data' => $product
        ], 201);
    }
}
