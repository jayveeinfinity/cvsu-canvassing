<?php
session_start(); // Ensure session is started

// Include database connection
require 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Output the POST data for inspection
    var_dump($_POST);

    // Sanitize and validate the user inputs
    $user_id = $_SESSION['user_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['Full_Name']);
    $department = mysqli_real_escape_string($conn, $_POST['Department']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone']); // Fixed key to match form field
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Handle profile image upload
    $new_image_name = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $profile_image = $_FILES['profile_image'];
        $upload_dir = 'assets/img/';
        $new_image_name = time() . '_' . $profile_image['name']; // Generate a unique name for the image
        $upload_path = $upload_dir . $new_image_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($profile_image['tmp_name'], $upload_path)) {
            // Successfully uploaded the file
        } else {
            echo "Error uploading image.";
        }
    }

    // Prepare the update query
    $update_query = "UPDATE users SET Full_name = ?, Department = ?, Phone_number = ?, Email = ?";

    // If a new image was uploaded, update the profile image field as well
    if ($new_image_name) {
        $update_query .= ", profile_image = ?";
    }

    $update_query .= " WHERE user_id = ?";

    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        // Bind the parameters
        if ($new_image_name) {
            // 6 parameters if an image is uploaded
            mysqli_stmt_bind_param($stmt, 'ssssss', $full_name, $department, $phone, $email, $new_image_name, $user_id);
        } else {
            // 5 parameters if no image is uploaded
            mysqli_stmt_bind_param($stmt, 'sssss', $full_name, $department, $phone, $email, $user_id);
        }

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the profile page after a successful update
            header("Location: userprofile.php");
            exit(); // Make sure no further code is executed after redirect
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the update query: " . mysqli_error($conn);
    }
}
?>
