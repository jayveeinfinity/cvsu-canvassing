<?php
session_start();

require("config.php");
require("function.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <link rel="stylesheet" href="assets/css/login.css">
    <style>
        .error-message {
            background-color: #ffcccc;
            color: #cc0000;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="bg-img">
        <div class="content">
            <header>Login Form</header>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" required placeholder="Email" name="email">
                </div>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="password" class="pass-key" required placeholder="Password" name="password">
                    <span class="show"></span>
                </div>
                <div class="pass">
                    <a href="forgotpassform.php">Forgot Password?</a>
                </div>
                <div class="field">
                    <input type="submit" value="LOGIN">
                </div>
            </form>

            <div class="login">
                <span>Don't have an account? <a href="signup.php" class="link signup-link">Signup</a></span>
            </div>

            <div class="line"></div>

            <!-- Google Sign-Up Section -->
            <div id="g_id_onload"
                 data-client_id="YOUR_GOOGLE_CLIENT_ID"
                 data-login_uri="verify_google_token.php"
                 data-auto_prompt="false">
            </div>

            <div class="g_id_signin"
                 data-type="standard"
                 data-shape="rectangular"
                 data-theme="outline"
                 data-text="continue_with"
                 data-size="large"
                 data-logo_alignment="left">
            </div>
        </div>
    </div>

    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        showBtn.addEventListener('click', function () {
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

        function handleCredentialResponse(response) {
            const idToken = response.credential;

            fetch("verify_google_token.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id_token: idToken }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log("User logged in:", data.user);
                    // Redirect or handle user session
                    window.location.href = "dashboard.php"; // Example redirect
                } else {
                    console.error(data.message);
                }
            });
        }

        window.onload = function () {
            google.accounts.id.initialize({
                client_id: "1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com",
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.querySelector('.g_id_signin'),
                { theme: "outline", size: "large" }
            );
        };
    </script>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
