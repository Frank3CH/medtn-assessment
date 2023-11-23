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
    public function productList(Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
    
        return $this->render('product/list.html.twig', ['cart' => $cart,'products' => $products]);
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
            $cartCount = count($session->get('cart', []));
    
            return new JsonResponse(['success' => true, 'message' => 'Product added to cart', 'cartCount' => $cartCount]);
        }
    
        return $this->redirectToRoute('shopping_cart');
    }

    /**
     * @Route("/remove-from-cart/{index}", name="remove_from_cart")
     */
    public function removeFromCart(Request $request, int $index): JsonResponse
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $session->set('cart', array_values($cart));

            return new JsonResponse(['success' => true, 'message' => 'Product removed from cart']);
        }

        return new JsonResponse(['success' => false, 'message' => 'Product not found in cart']);
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(Request $request): JsonResponse
    {
       

        //  clear the cart 
        $session = $request->getSession();
        $session->set('cart', []);

        return new JsonResponse(['success' => true, 'message' => 'Checkout successful']);
    }
}
