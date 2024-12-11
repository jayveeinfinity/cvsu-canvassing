<?php
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the category name from the form
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']); // Sanitize input to avoid SQL injection

    // Check if the category name is empty
    if (empty($category_name)) {
        echo "Category name is required!";
    } else {
        // SQL query to insert the new category into the 'categories' table
        $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";

        // Execute the query and check if it was successful
        if ($conn->query($sql) === TRUE) {
            // Redirect with a success message
            header("Location: adminpanel.php?success=1"); // Add success query parameter to the URL
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
} else {
    // If form not submitted, redirect back to the admin panel
    header("Location: adminpanel.php");
    exit();
}
?>
