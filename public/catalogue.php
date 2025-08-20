<?php
session_start();
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">

<div class="grid">
  <?php foreach($PRODUCTS as $sku=>$p): ?>
    <div class="card">
      <img src="/assets/images/<?php echo $p['image']; ?>" 
           alt="<?php echo htmlspecialchars($p['name']); ?>" 
           height="200" width="200">
      
      <div class="body">
        <h3><?= htmlspecialchars($p['name']) ?></h3>
        <p class="price">₦<?= number_format($p['price']) ?></p>
        <button class="btn add-to-cart" data-sku="<?= $sku ?>">Add to cart</button>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<a href="cart.php" class="view-cart-link">🛒 View Cart</a>

<script src="/assets/js/app.js" defer></script>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
