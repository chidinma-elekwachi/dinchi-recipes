<?php
session_start();
require_once __DIR__ . '/../lib/Database.php';
require_once __DIR__ . '/../lib/Mailer.php';
require_once __DIR__ . '/../config/config.php';

$orderId = $_GET['merchant_tx_ref'] ?? ($_GET['order'] ?? null);

// Generate download token for order (if not already created)
if ($orderId) {
  $order = DB::findOne('orders', ['_id'=>$orderId]);
  if ($order && ($order['status'] ?? '') === 'paid') {
    if (empty($order['download_token'])) {
      $token = bin2hex(random_bytes(16));
      DB::updateOne('orders',['_id'=>$orderId],['$set'=>['download_token'=>$token,'token_expires'=>date('c', time()+86400)]]);
    } else {
      $token = $order['download_token'];
    }
    $downloadLink = env('APP_URL').'/download.php?token='.$token;
    $msg = "Payment confirmed. A download link has been emailed to you. <br> <a class='btn' href='".htmlspecialchars($downloadLink)."'>Download now</a>";
  } else {
    $msg = "Your payment is being processed. If successful, you'll receive an email with your download link shortly.";
  }
} else {
  $msg = "Thanks for your purchase!";
}
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<div class="alert ok"><?= $msg ?></div>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>