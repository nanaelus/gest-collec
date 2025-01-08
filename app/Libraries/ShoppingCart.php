<?php

namespace App\Libraries;

class ShoppingCart
{
    protected $session;

    public function __construct() {
        //accès à la session
        $this->session = session();

        //Initialisation du panier
        if(!$this->session->has('cart')) {
            $this->session->set('cart', [
                'items' => [],
                'count' => 0,
                'total' => 0
            ]);
        }
    }

    public function addProduct(array $product) {
        //Récupérer le panier actuel depuis le session
        $cart = $this->session->get('cart') ?? ['items' => [], 'count' => 0, 'total' => 0]; // Initialiser un panier vide si absent

        // Vérifier si le produit existe déjà dans le panier
        $found =false;
        foreach ($cart['items'] as &$item) {
            if ($item['id'] == $product['id']) {
                //Si le produit existe déjà, augmenter la quantité
                $item['quantity'] += $product['quantity'];
                $found = true;
                break;
            }
        }

        //Si le produit n'a pas été trouvé, l'ajouter comme nouvel élément
        if(!$found) {
            $cart['items'][] = $product;
        }

        //Recalculer le total du panier
        $cart['total'] = $this->calculateTotal($cart['items']);
        $cart['count'] = $this->calculateCountItem($cart['items']);
        //Mettre à jour le sassion avec le nouveau panier
        $this->session->set('cart', $cart);
    }

    protected function calculateTotal(array $items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }

    protected function calculateCountItem(array $items) {
        $count = 0;
        foreach ($items as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}