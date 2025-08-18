<?php
session_start();
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<div class="grid">
  <?php foreach($PRODUCTS as $sku=>$p): ?>
    <div class="card">
      <div class="img"><?= strtoupper(substr($p['sku'],0,2)) ?></div>
      <div class="body">
        <h3><?= htmlspecialchars($p['name']) ?></h3>
        <p class="price">₦<?= number_format($p['price']) ?></p>
        <button class="btn" data-add data-sku="<?= $sku ?>">Add to cart</button>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<script src="/assets/js/app.js" defer></script>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>