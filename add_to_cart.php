<?php
session_start();

header('Content-Type: application/json');
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to add items to your cart.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? '';

    if ($name && $price && $image) {
        // Initialize cart session array if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add product to session cart
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => floatval($price),
            'image' => $image
        ];

        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
exit;
?>
