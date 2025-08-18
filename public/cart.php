<?php
require_once __DIR__ . '/../lib/Cart.php';
require_once __DIR__ . '/products.php';

header('Content-Type: application/json');
$action = $_POST['action'] ?? null;
if ($action === 'add') {
  $sku = $_POST['sku'] ?? '';
  if (!isset($PRODUCTS[$sku])) { echo json_encode(['ok'=>false,'message'=>'Invalid product']); exit; }
  Cart::add($sku, 1);
  echo json_encode(['ok'=>true,'message'=>'Added to cart','count'=>array_sum(Cart::items())]); exit;
}
if ($action === 'clear') { Cart::clear(); echo json_encode(['ok'=>true]); exit; }
echo json_encode(['ok'=>false,'message'=>'No action']);