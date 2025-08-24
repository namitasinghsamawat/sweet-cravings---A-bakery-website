<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: admin_product.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch existing product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: admin_product.php");
    exit();
}

$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image_url'];

    $update_stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, image_url = ? WHERE id = ?");
    $update_stmt->bind_param("ssdsi", $name, $category, $price, $image, $id);
    $update_stmt->execute();

    header("Location: admin_product.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Price (₹):</label><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>"><br><br>

        <label>Image URL:</label><br>
        <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>"><br><br>

        <button type="submit">Update Product</button>
    </form>
    <br>
    <a href="admin_product.php">← Back to Product List</a>
</body>
</html>
