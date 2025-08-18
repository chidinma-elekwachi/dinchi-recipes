document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('[data-add]').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const sku = btn.getAttribute('data-sku');
      fetch('/cart.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({action:'add', sku})
      }).then(r=>r.json()).then(d=>{
        alert(d.message || 'Added to cart');
        if (d.count !== undefined) {
          const el = document.getElementById('cartCount');
          if (el) el.textContent = d.count;
        }
      });
    });
  });
});