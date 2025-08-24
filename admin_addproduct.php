<?php
include 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $category, $price, $image);

    if ($stmt->execute()) {
        header("Location: admin_product.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error adding product: " . $stmt->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form method="post">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Price (₹):</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category"><br><br>

        <label>Image URL:</label><br>
        <input type="text" name="image_url"><br><br>

        <button type="submit">Add Product</button>
    </form>

    <br>
    <a href="admin_product.php">← Back to Product List</a>
</body>
</html>
