<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sweet Cravings - Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f5e1da;
    }

    .navbar {
      background-color: #3d342a !important;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .navbar.scrolled {
      background-color: #2b241d !important;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .navbar-nav .nav-link {
      color: #F5F0E1 !important;
    }

    .navbar-nav .nav-link:hover {
      background-color: #3C2F20;
      border-radius: 5px;
      color: #ffffff !important;
    }

    .navbar-brand {
      font-family: 'Satisfy', cursive;
      font-size: 1.9rem;
      color: white;
    }

    .navbar-brand img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
    }

    .cart-item {
      margin-bottom: 20px;
    }

    .cart-total {
      font-size: 20px;
      font-weight: bold;
    }

    .btn-proceed {
      background-color: #6A4E23 !important;
      color: white !important;
      font-weight: bold;
      border-radius: 5px;
      padding: 12px 30px;
      font-size: 18px;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border: none !important;
    }

    .btn-proceed:hover {
      background-color: #3C2F20 !important;
      transform: scale(1.05);
    }

    .btn-proceed:active {
      background-color: #5A3D1B !important;
      transform: scale(1);
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <img src="images/logo.jpg" alt="Bakery Logo" width="30" height="30" class="me-2">
        Sweet Cravings
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="product.html">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Cart Items -->
  <section class="container mt-4">
    <h2 class="text-center">Your Cart</h2>
    <div id="cartItems" class="row">
      <?php
      $total = 0;
      if (!empty($_SESSION['cart'])):
        foreach ($_SESSION['cart'] as $index => $item):
          $total += $item['price'];
          ?>
          <div class="col-md-4 cart-item" id="cart-item-<?= $index ?>">
            <div class="card shadow-sm">
              <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top"
                alt="<?= htmlspecialchars($item['name']) ?>" style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                <p class="card-text">₹<?= number_format($item['price'], 2) ?></p>
                <!-- Remove button with data-index -->
                <button class="btn btn-sm btn-danger remove-btn" data-index="<?= $index ?>">Remove</button>
              </div>
            </div>
          </div>
        <?php endforeach; else: ?>
        <p class="text-center">Your cart is empty.</p>
      <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <div class="cart-total">
        <span>Total: ₹<span id="totalPrice"><?= number_format($total, 2) ?></span></span>
      </div>
      <button class="btn btn-proceed" onclick="checkLogin()">Proceed to Checkout</button>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function checkLogin() {
      window.location.href = 'checkout.php';
    }

    document.querySelectorAll('.remove-btn').forEach(button => {
      button.addEventListener('click', function () {
        const index = this.getAttribute('data-index');

        if (!confirm('Remove this item from cart?')) return;

        fetch('remove_from_cart.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ index: index })
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              alert('Item removed from cart.');
              // Reload page to update cart
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => console.error('Error:', error));
      });
    });
  </script>

</body>

</html>