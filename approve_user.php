<?php
session_start();
include('config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Check if user ID is set in the URL
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Update user approval status in the database
    $query = "UPDATE users SET is_approved = TRUE WHERE user_id = '$user_id'";
    mysqli_query($conn, $query);

    // Fetch user email from the database
    $user_query = "SELECT email FROM users WHERE user_id = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $user_email = $user_data['email'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'angelolagmay1234@gmail.com';  // SMTP username
        $mail->Password = 'ecztmtgxdaxtpfwa';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('admin@gmail.com', 'Admin');
        $mail->addAddress($user_email);

        // Content
        $mail->isHTML(true);
            $mail->Subject = 'Account Approved';
            $mail->Body = '
                <html>
                <head>
                    <style>
                        .card {
                            background-color: #ffffff;
                            border-radius: 10px;
                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            max-width: 400px;
                            margin: 0 auto;
                        }
                        .header {
                            background-color: #006d24;
                            color: #ffffff;
                            border-radius: 10px 10px 0 0;
                            padding: 15px 20px;
                            text-align: center;
                        }
                        .content {
                            padding: 20px;
                            text-align: center;
                        }
                        .footer {
                            background-color: #f5f5f5;
                            border-radius: 0 0 10px 10px;
                            padding: 15px 20px;
                            text-align: center;
                        }
                        .button {
                            background-color: #006d24;
                            color: #ffffff;
                            padding: 10px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            transition: background-color 0.3s ease;
                        }
                        .button:hover {
                            background-color: #005b1a;
                        }
                    </style>
                </head>
                <body>
                    <div class="card">
                        <div class="header">
                            <h2>Account Approved</h2>
                        </div>
                        <div class="content">
                            <p>Your account has been approved by the admin.</p>
                            <p>Click the button below to log in to your account:</p>
                            <a href="http://localhost/cvsucanvassing/login.php" class="button">Log In</a>
                        </div>
                        <div class="footer">
                            <p>Best regards,<br>Admin Team</p>
                        </div>
                    </div>
                </body>
                </html>
            ';
            $mail->AltBody = 'Your account has been approved by the admin. Log in to your account at http://localhost/cvsucanvassing/login.php';


        // Send email
        $mail->send();
        
        // Redirect to admin panel after sending email
        header("Location: adminpanel.php");
        die;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
