<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the incoming data
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_code = mysqli_real_escape_string($conn, $_POST['product_code']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Optionally validate product_price if it's included in the form
    // $product_price = str_replace(',', '', mysqli_real_escape_string($conn, $_POST['product_price']));

    // Check if any required fields are empty
    if (empty($description) || empty($product_name) || empty($product_code) || empty($category)) {
        echo 'All fields are required!';
        exit();
    }

    // Check for duplicate barcode
    $query = "SELECT * FROM product WHERE product_code = '$product_code' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo 'Duplicate product code detected!';
        exit();
    } else {
        // Insert data into the database
        $insert_query = "INSERT INTO product (description, product_name, product_code, category) 
                         VALUES ('$description', '$product_name', '$product_code', '$category')";

        if (mysqli_query($conn, $insert_query)) {
            // On success, redirect to the admin product page
            header('Location: adminproduct.php');
            exit();
        } else {
            // Display detailed error message
            echo 'Error: ' . mysqli_error($conn);
            exit();
        }
    }
} else {
    // If the request method is not POST, redirect to an error page or display an error message
    echo 'Invalid request method';
    exit();
}
?>
