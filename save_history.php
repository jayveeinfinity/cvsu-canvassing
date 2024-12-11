<?php
include("config.php");
include("function.php"); 

// Check if user is logged in, if not, redirect to login page
check_login($conn);

// Fetch the user_id from session
$user_id = $_SESSION['user_id']; 

// Check if the form is submitted via the "Save Only" button
if (isset($_POST['save_only'])) {
    $ref_no = mysqli_real_escape_string($conn, $_POST['input_one']);
    $company_name = mysqli_real_escape_string($conn, $_POST['input_two']);
    $address = mysqli_real_escape_string($conn, $_POST['input_four']);
    $tin = mysqli_real_escape_string($conn, $_POST['input_five']);
    $date = mysqli_real_escape_string($conn, $_POST['input_three']);
    $submission_deadline = mysqli_real_escape_string($conn, $_POST['input_six']);
    $delivery_period = mysqli_real_escape_string($conn, $_POST['input_seven']);
    $price_validity = mysqli_real_escape_string($conn, $_POST['input_eight']);
    $approved_budget = mysqli_real_escape_string($conn, $_POST['input_nine']);

    // Fetch items from the cart
    $query = "SELECT * FROM cart";
    $result = mysqli_query($conn, $query);
    $grand_total = 0;
    $items = [];

    // Insert data into the canvas_history table first
    $sql_history = "INSERT INTO canvas_history (
                        user_id, ref_no, company, address, tin, date, submission_deadline, 
                        delivery_period, price_validity, approved_budget, grand_total
                    ) VALUES (
                        '$user_id', '$ref_no', '$company_name', '$address', '$tin', '$date', '$submission_deadline', 
                        '$delivery_period', '$price_validity', '$approved_budget', '$grand_total'
                    )";

    if (mysqli_query($conn, $sql_history)) {
        // Get the last inserted canvas_history id to associate items with the history record
        $history_id = mysqli_insert_id($conn);

        // Insert each item into the canvas_history_items table after canvas_history insert
        while ($row = mysqli_fetch_assoc($result)) {
            $description = mysqli_real_escape_string($conn, $row['description']);
            $qty = $row['qty'];
            $product_name = mysqli_real_escape_string($conn, $row['product_name']);
            $total_price = $row['total_price'];
            $user_id = $row['user_id'];
            // Update grand total
            $grand_total += $total_price;

            // Insert each item into the canvas_history_items table
            $sql_item = "INSERT INTO canvas_history_items (history_id, description, qty, product_name, total_price,user_id) 
                         VALUES ('$history_id', '$description', '$qty', '$product_name', '$total_price','$user_id')";

            if (!mysqli_query($conn, $sql_item)) {
                echo "<script>alert('Error saving item: " . mysqli_error($conn) . "');</script>";
                exit;
            }
        }

        // Now update grand_total in the canvas_history table
        $update_grand_total = "UPDATE canvas_history SET grand_total = '$grand_total' WHERE id = '$history_id'";
        if (!mysqli_query($conn, $update_grand_total)) {
            echo "<script>alert('Error updating grand total: " . mysqli_error($conn) . "');</script>";
        }

        echo "<script>
                alert('Purchase history saved successfully!');
                window.location.href = 'print.php';
              </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
