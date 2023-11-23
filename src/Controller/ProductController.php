<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_list")
     */
    public function productList(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
    
        return $this->render('product/list.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/cart", name="shopping_cart")
     */
    public function shoppingCart(Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'];
        }

        return $this->render('product/cart.html.twig', ['cart' => $cart , 'totalPrice' => $totalPrice,]);
    }

   /**
     * @Route("/add-to-cart/{id}", name="add_to_cart")
     */
    public function addToCart(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $session = $request->getSession();
        $cart = $session->get('cart', []);

        $cart[] = [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            // Add other properties as needed
        ];

        $session->set('cart', $cart);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['success' => true, 'message' => 'Product added to cart']);
        }

        return $this->redirectToRoute('shopping_cart');
    }

    /**
     * @Route("/remove-from-cart/{index}", name="remove_from_cart")
     */
    public function removeFromCart(Request $request, int $index): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $session->set('cart', array_values($cart));
        }

        return $this->redirectToRoute('shopping_cart');
    }
}
