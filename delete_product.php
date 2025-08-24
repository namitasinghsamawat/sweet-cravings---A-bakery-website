<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: admin_product.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_product.php");
exit();
?>
