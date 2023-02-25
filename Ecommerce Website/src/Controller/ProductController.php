<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show($id, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $product = $productRepository->find($id);
        $category = $categoryRepository->find($id);
        $products = $category->getProducts();

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'product' => $product,
            'category' => $category
        ]);
    }
}


