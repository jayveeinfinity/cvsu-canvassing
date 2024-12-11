<?php 
session_start();

include("config.php");
include("function.php");

$error_message = ""; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $full_name = $_POST['Full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['Department'];
    $phone_number = $_POST['Phone_number'];
    $usertype = $_POST['usertype'];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Generate a random user ID
        $user_id = random_num(10);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (user_id, full_name, email, password, department, phone_number, usertype, is_approved) VALUES (?, ?, ?, ?, ?, ?,?, FALSE)");
        $stmt->bind_param("sssssss", $user_id, $full_name, $email, $hashed_password, $department, $phone_number,  $usertype);

        if ($stmt->execute()) {
            header("Location: login.php");
            die;
        } else {
            $error_message = "Error: Could not create account. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "Please enter a valid email and password.";
    }
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> CvSU ONLINE CANVASSING </title>

        <!-- favicon -->
        <link rel="icon" href="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" type="image/gif" sizes="18x16">

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/login.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>

      <!-- Additional Styles for Red Card -->
    <style>
        .error-message {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none; /* Default hidden */
        }
        .error-message.visible {
            display: block; /* Show error message if visible */
        }

        /* Style the container of the dropdown */
.field {
    position: relative;
    margin-bottom: 10px;
}


/* Style the dropdown select element */
.field select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ddd;  /* Consistent border style */
    border-radius: 5px;
    font-size: 16px;
    background-color: #f9f9f9; /* Light background color */
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.3s ease;
}

/* Change border color on focus */
.field select:focus {
    border-color: #3498db;  /* Blue border on focus */
}

/* Optional: Style the icon inside the dropdown (hidden for consistency) */
.field .fa-user {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    color: #999;
    font-size: 18px;
    pointer-events: none; /* Prevent icon from interfering with dropdown interaction */
}

/* Add space between the select box and icon (icon hidden to match input fields) */
.field select {
    padding-left: 10px;  /* Keeps the padding for consistency */
}
    </style>
  </head>
  <body>
    <div class="bg-img">
        <div class="content">
            <header>Signup</header>
            
            <!-- Error Message -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message visible"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post">

                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Full Name" name="Full_name">
                </div>

                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Email" name="email">
                </div>
                
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="password" class="pass-key" required placeholder="Password" name="password">
                    <span class="show"></span>
                </div>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Department" name="Department">
                </div>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <select required name="usertype">
                        <option value="canvasser">Canvasser</option>
                        <option value="supplier">Supplier</option>
                    </select>
                </div>
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Phone number" name="Phone_number">
                </div>

                <div class="field">
                    <input type="submit" value="CREATE ACCOUNT">
                </div>
            </form>
            
            <div class="login">
                <span>Already have an account? <a href="login.php">Login</a></span>
            </div>
        </div>

        <div class="line"></div>

        <script>
            const pass_field = document.querySelector('.pass-key');
            const showBtn = document.querySelector('.show');
            showBtn.addEventListener('click', function() {
                if (pass_field.type === "password") {
                    pass_field.type = "text";
                    showBtn.textContent = "HIDE";
                    showBtn.style.color = "#3498db";
                } else {
                    pass_field.type = "password";
                    showBtn.textContent = "SHOW";
                    showBtn.style.color = "#222";
                }
            });
        </script>
    </div>
</body>
</html>