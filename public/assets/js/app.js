// assets/js/app.js
document.addEventListener('DOMContentLoaded', function() {
  // Add to cart functionality
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const sku = this.dataset.sku;
      
      // Send AJAX request to add item to cart
      fetch('/add-to-cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `sku=${sku}`
      })
      .then(response => response.json())
      .then(data => {
        if(data.success) {
          // Update cart count in header
          document.getElementById('cartCount').textContent = data.cartCount;
          alert('Item added to cart!');
        } else {
          alert('Error adding item to cart');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });
});