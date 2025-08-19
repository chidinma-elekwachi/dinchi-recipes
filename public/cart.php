<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../lib/Cart.php';
require_once __DIR__ . '/products.php';

// Handle AJAX actions (add / clear)
$action = $_POST['action'] ?? null;
if ($action) {
    header('Content-Type: application/json');
    try {
        if ($action === 'add') {
            $sku = $_POST['sku'] ?? '';
            if (!isset($PRODUCTS[$sku])) {
                echo json_encode(['ok' => false, 'message' => 'Invalid product']);
                exit;
            }
            Cart::add($sku, 1);
            echo json_encode([
                'ok' => true,
                'message' => 'Added to cart',
                'count' => array_sum(Cart::items())
            ]);
            exit;
        }

        if ($action === 'clear') {
            Cart::clear();
            echo json_encode(['ok' => true]);
            exit;
        }

        echo json_encode(['ok' => false, 'message' => 'Invalid action']);
        exit;
        
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        exit;
    }
}

// ------- If no action, render the cart page -------
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">

<div class="cart-container">
  <h2>Your Cart</h2>
  <?php 
  try {
      $items = Cart::items(); 
  } catch (Exception $e) {
      echo '<p class="error">Error loading cart: ' . htmlspecialchars($e->getMessage()) . '</p>';
      $items = [];
  }
  ?>
  
  <?php if (empty($items)): ?>
      <p>Your cart is empty. <a href="catalogue.php">Go back to catalogue</a></p>
  <?php else: ?>
      <table class="cart-table">
          <thead>
              <tr>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Subtotal</th>
              </tr>
          </thead>
          <tbody>
          <?php 
          $total = 0;
          foreach ($items as $sku => $qty): 
              if (!isset($PRODUCTS[$sku])) {
                  continue; // Skip invalid products
              }
              $product = $PRODUCTS[$sku];
              $subtotal = $product['price'] * $qty;
              $total += $subtotal;
          ?>
              <tr>
                  <td><?= htmlspecialchars($product['name']) ?></td>
                  <td><?= htmlspecialchars($qty) ?></td>
                  <td>₦<?= number_format($product['price']) ?></td>
                  <td>₦<?= number_format($subtotal) ?></td>
              </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
              <tr>
                  <td colspan="3" style="text-align:right"><strong>Total:</strong></td>
                  <td><strong>₦<?= number_format($total) ?></strong></td>
              </tr>
          </tfoot>
      </table>
      <div class="cart-actions">
          <a href="checkout.php" class="btn">Proceed to Checkout</a>
          <form method="POST" action="cart.php" style="display:inline">
              <input type="hidden" name="action" value="clear">
              <button type="submit" class="btn danger" onclick="return confirm('Are you sure you want to clear your cart?');">Clear Cart</button>
          </form>
      </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>