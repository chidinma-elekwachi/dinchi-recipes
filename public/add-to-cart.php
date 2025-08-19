<?php
// add-to-cart.php
session_start();
require_once __DIR__ . '/products.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'] ?? '';
    
    if (!empty($sku) && isset($PRODUCTS[$sku])) {
        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Add item to cart or increment quantity
        if (isset($_SESSION['cart'][$sku])) {
            $_SESSION['cart'][$sku] += 1;
        } else {
            $_SESSION['cart'][$sku] = 1;
        }
        
        // Calculate total items in cart
        $cartCount = array_sum($_SESSION['cart']);
        
        echo json_encode([
            'success' => true,
            'cartCount' => $cartCount
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid product'
]);