<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingController extends AbstractController
{
    #[Route('/shopping', name: 'shopping_show')]
    public function shopping(Request $request): Response
    {
        $session = $request->getSession();
        $shopping = $session->get('shopping', []);

        $products = [];
        foreach ($shopping as $id => $quantity) {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->find($id);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        // afficher les produits dans la vue panier
        return $this->render('shopping/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/shopping/add/{id}', name: 'shopping_add')]
    public function add($id, Request $request): Response
    {
        $session = $request->getSession();
        $shopping = $session->get('shopping', []);
        if (!isset($shopping[$id])) {
            $shopping[$id] = 0;
        }
        $shopping[$id]++;
        $session->set('shopping', $shopping);

        return $this->redirectToRoute('shopping');
    }

    #[Route('/shopping/delete/{id}', name: 'shopping_delete')]
    public function delete($id, Request $request): Response
    {
        $session = $request->getSession();
        $shopping = $session->get('shopping', []);
        unset($shopping[$id]);
        $session->set('shopping', $shopping);

        return $this->redirectToRoute('panier');
    }

    #[Route('/shopping/order', name: 'shopping_order')]
    public function commander(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $shopping = $session->get('shopping', []);

        // enregistrer la commande en base de données

    }

     function getDoctrine()
    {
    }
}