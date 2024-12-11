<?php
include("config.php");

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Prepare the SQL statement
    $query = "DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        // Successfully deleted
        $_SESSION['message'] = "Product deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        // Failed to delete
        $_SESSION['message'] = "Product could not be deleted.";
        $_SESSION['message_type'] = "error";
    }

    // Close the statement
    $stmt->close();

    // Redirect to adminproduct.php
    header('Location: adminproduct.php');
    exit();
} else {
    // If delete_id is not set, redirect with an error message
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "error";
    header('Location: adminproduct.php');
    exit();
}
?>
