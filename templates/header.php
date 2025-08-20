<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DinChi Recipes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header>
  <div class="nav">
    <h1><a href="/index.php">🍲 DinChi Recipes</a></h1>
    
    <!-- Hamburger -->
    <button class="hamburger" id="menuToggle">☰</button>

    <div class="nav-links" id="navLinks">
      <a class="btn secondary" href="/catalogue.php">Catalogue</a>
      
      <!-- Cart with icon -->
      <a class="btn secondary" href="/cart.php">
        🛒 <span id="cartCount">
          <?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>
        </span>
      </a>
      
      <?php if(isset($_SESSION['user'])): ?>
        <a class="btn secondary" href="/logout.php">Logout</a>
        <span class="badge">Hi, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
      <?php else: ?>
        <a class="btn secondary" href="/login.php">Login</a>
        <a class="btn" href="/register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<script>
  // Toggle mobile menu
  document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    
    menuBtn.addEventListener('click', () => {
      navLinks.classList.toggle('show');
    });
  });
</script>
