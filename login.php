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
        .login-with-google-btn {
            transition: background-color .3s, box-shadow .3s;
                
            padding: 12px 16px 12px 42px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
            
            color: #757575;
            font-size: 14px;
            font-weight: 500;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif;
            
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 12px 11px;
            
            &:hover {
                box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
            }
            
            &:active {
                background-color: #eeeeee;
            }
            
            &:focus {
                outline: none;
                box-shadow: 
                0 -1px 0 rgba(0, 0, 0, .04),
                0 2px 4px rgba(0, 0, 0, .25),
                0 0 0 3px #c8dafc;
            }
            
            &:disabled {
                filter: grayscale(100%);
                background-color: #ebebeb;
                box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
                cursor: not-allowed;
            }
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
            <a class="login-with-google-btn" href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&access_type=online&client_id=1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%2Fcvsu-canvassing%2Fcallback.php&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&approval_prompt=auto">
                Sign in with Google
            </a>

            <!-- <a href="https://accounts.google.com/o/oauth2/v2/auth?response_type=code&access_type=online&client_id=1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%2Fcvsu-canvassing%2Fcallback.php&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&approval_prompt=auto">Sign in with google (REAL)</a>

            <div id="g_id_onload"
                 data-client_id="1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com"
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
            </div> -->
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
                    window.location.href = "index.php";
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
