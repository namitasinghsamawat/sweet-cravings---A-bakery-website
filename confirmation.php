<?php
session_start();
require 'connect_db.php';

if (!isset($_GET['order_id'])) {
  echo "No order specified.";
  exit;
}

$orderId = intval($_GET['order_id']);

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
  echo "Order not found.";
  exit;
}

// Fetch order items
$stmtItems = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmtItems->bind_param("i", $orderId);
$stmtItems->execute();
$orderItems = $stmtItems->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order Confirmed - Sweet Cravings</title>
  <link rel="icon" href="images.png/logo_design.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #998983;
      text-align: center;
      padding: 100px 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #4a3c31;
    }
    .card {
      background-color: #f4dfcc;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: 0 auto;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-back-home {
      background-color: #d2b48c;
      color: white;
      font-weight: 600;
      padding: 10px 25px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }
    .btn-back-home:hover {
      background-color: #b7986d;
      color: white;
    }
    .order-summary {
      text-align: left;
      margin-top: 20px;
    }
    .order-summary h4 {
      margin-bottom: 15px;
    }
    .order-summary ul {
      list-style: none;
      padding-left: 0;
    }
    .order-summary li {
      display: flex;
      justify-content: space-between;
      padding: 6px 0;
      border-bottom: 1px solid #ccc;
    }
    .order-summary li:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1 class="mb-4">Thank You!!</h1>
    <p>Your order has been placed successfully.</p>

    <div class="order-summary">
      <h4>Order Details</h4>
      <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
      <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
      <p><strong>Shipping Address:</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
      <p><strong>Payment Method:</strong> <?= htmlspecialchars(strtoupper($order['payment_method'])) ?></p>
      <p><strong>Payment Status:</strong> <?= htmlspecialchars(ucfirst($order['payment_status'])) ?></p>

      <h4>Items Ordered</h4>
      <ul>
        <?php while ($item = $orderItems->fetch_assoc()): ?>
          <li>
            <span><?= htmlspecialchars($item['product_name']) ?> x <?= $item['quantity'] ?></span>
            <span>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
          </li>
        <?php endwhile; ?>
      </ul>
      <p style="text-align:right; font-weight:bold; margin-top:15px;">
        Total Amount: ₹<?= number_format($order['total_amount'], 2) ?>
      </p>
    </div>

    <a href="index.php" class="btn-back-home">Back to Home</a>
  </div>
</body>
</html>

