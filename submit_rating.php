<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $rating = intval($_POST['rating']);
    
    if ($product_id > 0 && $rating >= 1 && $rating <= 5) {
        // Optionally, check if user already rated this product and update instead of insert
        $sql = "INSERT INTO ratings (product_id, rating) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $rating);
        if ($stmt->execute()) {
            echo "Rating submitted successfully.";
        } else {
            echo "Error submitting rating.";
        }
        $stmt->close();
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
