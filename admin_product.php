<?php
include 'auth.php';
include 'db.php';

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
</head>

<body>
    <h2>Product List</h2>
    <a href="dashboard.php">← Back to Dashboard</a> |
    <a href="admin_addproduct.php">+ Add Product</a>
    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['category'] ?></td>
                <td>₹<?= $row['price'] ?></td>
                <td>
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="/Sweet-Cravings/<?= htmlspecialchars($row['image_url']) ?>" width="60" alt="Product Image">
                    <?php else: ?>
                        <span>No image</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete_product.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>