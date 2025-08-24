<?php
session_start();
require 'connect_db.php'; // Your DB connection file

if (empty($_SESSION['cart'])) {
  header('Location: cart.php');
  exit;
}

$errors = [];
$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customerName = trim($_POST['name'] ?? '');
  $customerEmail = trim($_POST['email'] ?? '');
  $shippingAddress = trim($_POST['address'] ?? '');
  $paymentMethod = trim($_POST['payment_method'] ?? '');

  // Validation
  if (!$customerName) {
    $errors[] = 'Full name is required.';
  }
  if (!$customerEmail || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required.';
  }
  if (!$shippingAddress) {
    $errors[] = 'Shipping address is required.';
  }
  if (!$paymentMethod) {
    $errors[] = 'Payment method is required.';
  }

  if (empty($errors)) {
    // Calculate total
    foreach ($_SESSION['cart'] as $item) {
      $total += $item['price'] * ($item['quantity'] ?? 1);
    }

    $paymentStatus = ($paymentMethod === 'cod') ? 'pending' : 'pending';

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, shipping_address, total_amount, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $customerName, $customerEmail, $shippingAddress, $total, $paymentMethod, $paymentStatus);

    if ($stmt->execute()) {
      $orderId = $stmt->insert_id;

      // Insert order items
      $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");

      foreach ($_SESSION['cart'] as $item) {
        $productName = $item['name'];
        $price = $item['price'];
        $quantity = $item['quantity'] ?? 1;

        $itemStmt->bind_param("isdi", $orderId, $productName, $price, $quantity);
        $itemStmt->execute();
      }

      $itemStmt->close();
      $stmt->close();

      unset($_SESSION['cart']);
      header("Location: confirmation.php?order_id=$orderId");
      exit;

    } else {
      $errors[] = 'Failed to save order. Please try again.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sweet Cravings - Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
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
  
  </style>
</head>

<body>
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
          <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5 pt-5">
    <h2 class="mb-4 text-center">Checkout</h2>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-6">
        <form method="post" action="checkout.php" id="checkoutForm" novalidate>
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required
              value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3"
              required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
          </div>
          <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select" required>
              <option value="">Select Payment Method</option>
              <option value="cod">Cash on Delivery</option>
              <option value="online">Online Payment</option>
            </select>
          </div>

          <button type="submit" class="btn btn-success">Place Order</button>
        </form>
      </div>

      <div class="col-md-6">
        <h5>Order Summary</h5>
        <ul class="list-group mb-3">
          <?php
          $subtotal = 0;
          foreach ($_SESSION['cart'] as $item):
            $subtotal += $item['price'];
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($item['name']) ?>
              <span>₹<?= number_format($item['price'], 2) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="fw-bold">Total: ₹<?= number_format($subtotal, 2) ?></p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>