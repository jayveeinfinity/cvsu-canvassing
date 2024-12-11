<?php
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the unit name from the form
    $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']); // Sanitize input to avoid SQL injection

    // Check if the unit name is empty
    if (empty($unit_name)) {
        echo "Unit name is required!";
    } else {
        // SQL query to insert the new unit into the 'units' table
        $sql = "INSERT INTO units (unit_name) VALUES ('$unit_name')";

        // Execute the query and check if it was successful
        if ($conn->query($sql) === TRUE) {
            // Redirect with a success message
            header("Location: adminpanel.php?success=1"); // Adding success parameter to the URL
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
} else {
    // If form not submitted, redirect back to the form page
    header("Location: adminpanel.php"); // Replace with your desired redirect page
    exit();
}


?>
