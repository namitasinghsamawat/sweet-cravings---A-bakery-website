<?php
session_start();

header('Content-Type: application/json');

if (!isset($_POST['index'])) {
    echo json_encode(['status' => 'error', 'message' => 'No product index provided']);
    exit;
}

$index = intval($_POST['index']);

if (!isset($_SESSION['cart'][$index])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product index']);
    exit;
}

// Remove the item at $index
unset($_SESSION['cart'][$index]);

// Re-index array so keys are sequential after unset
$_SESSION['cart'] = array_values($_SESSION['cart']);

echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
