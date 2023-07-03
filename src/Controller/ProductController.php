<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function index(ProductRepository $ProductRepository): JsonResponse
    {
        return $this->json([
            'data' => $ProductRepository->findAll(),
        ]);
    }

    #[Route('/products/{product}', name: 'product_single', methods: ['GET'])]
    public function single(int $product, ProductRepository $ProductRepository): JsonResponse
    {
        $product = $ProductRepository->find($product);

        if(!$product) throw $this->createNotFoundException();

        return $this->json([
            'data' => $product
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
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    #[Route('/products/{product}', name: 'product_update', methods: ['PUT', 'PATCH'])] 
    public function update(int $product, Request $request, ManagerRegistry $doctrine, ProductRepository $ProductRepository): JsonResponse
    {   
        $product = $ProductRepository->find($product);

        if(!$product) throw $this->createNotFoundException();

        $data = $request->request->all();

        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setPricePromotion($data['pricePromotion']);
        $product->setTax($data['tax']);
        $product->setPromotion($data['promotion']);
        $product->setActive($data['active']);
        $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine->getManager()->flush();


        return $this->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 201);
    }

    #[Route('/products/{product}', name: 'product_remove', methods: ['DELETE'])]
    public function remove(int $product, Request $request, ProductRepository $ProductRepository): JsonResponse
    {   
        $product = $ProductRepository->find($product);

        if(!$product) throw $this->createNotFoundException();

        $ProductRepository->remove($product, true);

        return $this->json([
            'message' => 'Product removed successfully',
            'data' => $product
        ], 201);
    }
}
