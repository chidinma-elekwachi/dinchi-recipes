<header>
  <div class="nav">
    <h1><a href="/index.php">🍲 DinChi Recipes</a></h1>
    <div>
      <a class="btn secondary" href="/catalogue.php">Catalogue</a>
      <a class="btn secondary" href="/cart.php">Cart (<span id="cartCount"><?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?></span>)</a>
      <?php if(isset($_SESSION['user'])): ?>
        <span class="badge">Hi, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
        <a class="btn secondary" href="/logout.php">Logout</a>
      <?php else: ?>
        <a class="btn secondary" href="/login.php">Login</a>
        <a class="btn" href="/register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</header>