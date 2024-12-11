<?php
// Ensure this check is at the very top of your script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php'); // Ensure this file contains the database connection $conn

function check_login($conn)
{
    if(isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

        $result = mysqli_query($conn, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login
    header("Location: login.php");
    die;
}
function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

$error = ""; // Initialize error variable

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            // Check password and account approval
            if (password_verify($password, $user_data['password'])) {
                if ($user_data['is_approved']) {
                    $_SESSION['user_id'] = $user_data['user_id'];

                    // Redirect based on user type
                    if ($user_data['usertype'] == 'admin') {
                        header("Location: adminpanel.php");
                    } elseif ($user_data['usertype'] == 'supplier') {
                        header("Location: supplier_panel.php");  // Redirect supplier to their panel
                    } else {
                        header("Location: index.php");  // Default redirection for other users
                    }
                    die;
                } else {
                    $error = "Your account is not approved yet!";
                }
            } else {
                $error = "Incorrect email or password!";
            }
        } else {
            $error = "Incorrect email or password!";
        }
    } else {
        $error = "Please enter both email and password!";
    }
}
?>

