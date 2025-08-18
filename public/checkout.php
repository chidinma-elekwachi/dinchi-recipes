<?php
session_start();
require_once __DIR__ . '/../lib/Payment.php';
require_once __DIR__ . '/../lib/Database.php';
require_once __DIR__ . '/../lib/Mailer.php';
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/../config/config.php';

$items = $_SESSION['cart'] ?? [];
if(!$items){ header('Location:/view-cart.php'); exit; }

$total = 0; $lines=[];
foreach($items as $sku=>$qty){
  $p = $PRODUCTS[$sku];
  $sub = $p['price']*$qty;
  $total += $sub;
  $lines[] = ['sku'=>$sku,'name'=>$p['name'],'qty'=>$qty,'price'=>$p['price'],'file'=>$p['file']];
}
$orderId = uniqid('order_');
$customer_name = $_SESSION['user']['full_name'] ?? 'Guest Buyer';
$customer_email = $_SESSION['user']['email'] ?? ($_POST['email'] ?? null);
$customer_phone = $_POST['phone'] ?? '08000000000';

if($_SERVER['REQUEST_METHOD']==='POST'){
  // Save order
  DB::insert('orders',[
    '_id'=>$orderId,
    'email'=>$customer_email,
    'name'=>$customer_name,
    'phone'=>$customer_phone,
    'items'=>$lines,
    'amount'=>$total,
    'status'=>'pending',
    'created_at'=>date('c')
  ]);

  // Initiate MarasoftPay Standard Checkout
  $redirect = env('APP_URL').'/success.php';
  $webhook  = env('APP_URL').'/webhook.php';
  [$ok,$url] = Payment::initiateCheckout($orderId,$customer_name,$customer_email,$customer_phone,$total*100,$redirect,$webhook);
  if($ok){
    header('Location: '.$url);
    exit;
  } else {
    $err = $url;
  }
}

require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<?php if(!empty($err)): ?><div class="alert err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<div class="form">
  <h3>Checkout</h3>
  <p>Total: <strong>₦<?= number_format($total) ?></strong></p>
  <form method="post">
    <div class="input"><label>Email</label><input type="email" name="email" required value="<?= htmlspecialchars($customer_email ?? '') ?>"></div>
    <div class="input"><label>Phone</label><input name="phone" required value="<?= htmlspecialchars($customer_phone) ?>"></div>
    <button class="btn">Pay with MarasoftPay</button>
  </form>
</div>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>