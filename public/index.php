<?php
session_start();
require_once __DIR__ . '/../templates/header.php';

?>
<link rel="stylesheet" href="/assets/css/style.css">
<div class="grid">
  <div class="card">
    <div class="img">Fresh & Easy</div>
    <div class="body">
      <h3>Shop premium recipe PDFs</h3>
      <p>Learn Nigerian dishes with step-by-step guides.</p>
      <br>
      <a href="/catalogue.php" class="btn">Browse Catalogue</a>
    </div>
  </div>
  <div class="card">
    <div class="img">Secure</div>
    <div class="body">
      <h3>Secure checkout</h3>
      <p>We use MarasoftPay for fast, reliable payments in NGN.</p>
    </div>
  </div>
  <div class="card">
    <div class="img">Instant</div>
    <div class="body">
      <h3>Instant delivery</h3>
      <p>After payment, get an email to download your PDF.</p>
    </div>
  </div>
</div>
<script src="/assets/js/app.js" defer></script>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>