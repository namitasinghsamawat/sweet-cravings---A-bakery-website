<?php
include 'connect_db.php';


// Set JSON header
header('Content-Type: application/json');

// Get and sanitize search input
$search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$search = mysqli_real_escape_string($conn, $search);

// Build SQL query
$sql = "SELECT p.*,
  IFNULL((SELECT ROUND(AVG(rating), 1) FROM ratings r WHERE r.product_id = p.id), 0) AS avg_rating,
  IFNULL((SELECT COUNT(*) FROM ratings r WHERE r.product_id = p.id), 0) AS total_ratings
FROM products p";

if (!empty($search)) {
    $sql .= " WHERE LOWER(p.name) LIKE '%$search%' OR LOWER(p.category) LIKE '%$search%'";
}



// Execute the query
$result = mysqli_query($conn, $sql);

// Initialize product array
$products = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

// Output the products as JSON
echo json_encode($products);

// Close connection
mysqli_close($conn);
