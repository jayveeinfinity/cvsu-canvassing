<?php
session_start();
require('function.php');
require('config.php');
$user_data = check_login($conn);

// Handle updating quantity
if (isset($_POST['updateQuantity'])) {
    $pid = $_POST['pid']; // Product ID
    $newQty = $_POST['newQty']; // New quantity

    // Update the cart in the database
    $stmt = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $stmt->bind_param("ii", $newQty, $pid);
    if ($stmt->execute()) {
        echo "Quantity updated successfully!";
    } else {
        echo "Error updating quantity!";
    }
    exit;
}


// Clear all items from the cart
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All Items removed from the cart!';
    header('location:cart.php');
}



?>
