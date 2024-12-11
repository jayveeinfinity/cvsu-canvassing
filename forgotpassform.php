<?php
session_start();

require("config.php");

$error = "";
$success_message = "";

// Handle the forgot password form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email exists in the database
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Check if passwords match
            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
                if (mysqli_query($conn, $update_query)) {
                    $success_message = "Your password has been successfully reset!";
                } else {
                    $error = "Failed to reset password. Please try again later.";
                }
            } else {
                $error = "Passwords do not match!";
            }
        } else {
            $error = "No account found with that email address.";
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="assets/css/login.css">
    <style>
        .error-message {
            background-color: #ffcccc; /* Light red background */
            color: #cc0000; /* Dark red text color */
            padding: 10px; /* Add some padding */
            margin-bottom: 10px; /* Add some space below the error message */
        }
        .success-message {
            background-color: #ccffcc;
            color: #006600;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
  </head>
  <body>
    <div class="bg-img">
      <div class="content">
        <header>Forgot Password</header>
        
        <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="post">
          <div class="field">
            <span class="fa fa-user"></span>
            <input type="text" required placeholder="Enter your email" name="email">
          </div>
          <br>
          <div class="field">
            <span class="fa fa-lock"></span>
            <input type="password" required placeholder="Enter new password" name="new_password">
          </div>
          <br>
          <div class="field">
            <span class="fa fa-lock"></span>
            <input type="password" required placeholder="Confirm new password" name="confirm_password">
          </div>
          <br>
          <div class="field">
            <input type="submit" value="Reset Password">
          </div>
        </form>

        <div class="login">
          <span>Back to <a href="login.php">Login</a></span>
        </div>
      </div>
    </div>
  </body>
</html>
