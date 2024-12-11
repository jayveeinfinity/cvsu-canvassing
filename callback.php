<?php
require_once __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Oauth2;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php'); // Ensure this file contains the database connection $conn
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    foreach ($_GET as $key => $value) {
        $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if(isset($data['code']) && !empty($data['code'])) {
        $clientId = '1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com';
        $clientSecret = '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';

        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri('http://localhost/cvsu-canvassing/callback.php');
        $client->setScopes(Oauth2::USERINFO_EMAIL);

        // Set Google Token
        $token = $client->fetchAccessTokenWithAuthCode($data['code']);
        $client->setAccessToken($token);

        // Initialize Google Service Oauth2 and retrive user Google Information
        $gauth = new Oauth2($client);
        $googleInfo = $gauth->userinfo->get();
        echo '<pre>';
        print_r($googleInfo);
        echo '</pre>';

        if($googleInfo->hd == "cvsu.edu.ph") {
            // Check if canvasser
        } else {
            
        }

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
    exit;

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
;?>