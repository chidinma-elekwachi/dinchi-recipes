<?php
session_start();
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/../templates/header.php';
$items = $_SESSION['cart'] ?? [];
$total = 0;
?>
<link rel="stylesheet" href="/assets/css/style.css">
<div class="table">
  <table>
    <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
    <tbody>
      <?php foreach($items as $sku=>$qty): $p=$PRODUCTS[$sku]; $sub=$p['price']*$qty; $total+=$sub; ?>
        <tr>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= (int)$qty ?></td>
          <td>₦<?= number_format($p['price']) ?></td>
          <td>₦<?= number_format($sub) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div style="max-width:860px;margin:0 auto;padding:0 16px 24px;display:flex;justify-content:space-between;align-items:center">
  <div class="badge">Total: ₦<?= number_format($total) ?></div>
  <a class="btn" href="/checkout.php">Proceed to Checkout</a>
</div>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>