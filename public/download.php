<?php
require_once __DIR__ . '/../lib/Database.php';

$token = $_GET['token'] ?? null;
if (!$token) { http_response_code(400); echo 'Missing token'; exit; }
$order = DB::findOne('orders', ['download_token'=>$token]);
if (!$order) { http_response_code(404); echo 'Invalid token'; exit; }

if (strtotime($order['token_expires']) < time()) {
  http_response_code(403); echo 'Token expired'; exit;
}

// For simplicity, if multiple items, serve a simple text index of links;
// or stream the first one. Here, we stream the first item.
$item = $order['items'][0];
$filePath = __DIR__ . '/products/' . $item['file'];
if (!file_exists($filePath)) { http_response_code(404); echo 'File not found'; exit; }

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
readfile($filePath);