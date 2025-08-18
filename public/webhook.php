<?php
require_once __DIR__ . '/../lib/Database.php';
require_once __DIR__ . '/../lib/Mailer.php';
require_once __DIR__ . '/../config/config.php';

// Capture payload (MarasoftPay will POST here). For demo, accept 'merchant_tx_ref' and 'status'.
$payload = $_POST + json_decode(file_get_contents('php://input'), true) ?? [];
$orderId = $payload['merchant_tx_ref'] ?? $payload['reference'] ?? null;
$status  = strtolower($payload['status'] ?? 'success');

http_response_code(200);

if ($orderId && $status==='success') {
  $order = DB::findOne('orders', ['_id'=>$orderId]);
  if ($order) {
    $token = bin2hex(random_bytes(16));
    DB::updateOne('orders',['_id'=>$orderId],['$set'=>['status'=>'paid','download_token'=>$token,'token_expires'=>date('c', time()+86400)]]);

    $downloadLink = env('APP_URL').'/download.php?token='.$token;
    // Email buyer
    $html = "<p>Hi ".htmlspecialchars($order['name']).",</p>
             <p>Thanks for your purchase. Download your recipe(s) here (link valid for 24 hours):</p>
             <p><a href='{$downloadLink}'>{$downloadLink}</a></p>
             <p>Order ID: {$orderId}</p>";
    Mailer::send($order['email'], 'Your recipe download link', $html);

    // Email admin summary
    $summary = "New order paid\nOrder: {$orderId}\nName: {$order['name']}\nPhone: {$order['phone']}\nItems: ".json_encode($order['items']);
    Mailer::send(env('ADMIN_EMAIL'), 'New Paid Order', nl2br($summary));
  }
}
echo json_encode(['ok'=>true]);