<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    #[Route('/category/{id}/{sort}', name: 'category_show')]
    public function show($id, $sort = 'asc', CategoryRepository $categoryrepository, Request $request): Response
    {
        $category = $categoryrepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $sortOrder = $sort === 'desc' ? 'DESC' : 'ASC';

        $products = $categoryrepository->findProductsByCategoryAndSortOrder($category, $sortOrder);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'products' => $products,
            'sortOrder' => $sortOrder
        ]);
    }

}
