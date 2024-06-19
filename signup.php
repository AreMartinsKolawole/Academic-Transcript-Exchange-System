<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Sign up</title>
    <link rel="stylesheet" href="./css/style_signup.css">
    <link rel="icon" href="./img/Logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="navlinks">
            <img src="./img/Logo.png" alt="">
            <div class="nav">
                <a href="./index.php">HOME</a>
                <a href="./login.php">LOG IN</a>
            </div>
        </div>
        <div class="middle">

            <div class="left">
                <img src="./img/left.JPG" alt="img">
            </div>

            <div class="right">
                <div class="right">
                    <div class="form_field">
                        <img src="./img/Logo.png" alt="">
                        <h3 id="ca">Create an account</h3>
                        <?php 
                            if(isset($_GET['error']) && $_GET['error'] == 'user_exists') {
                                echo '<div class="error" style="font-size: 8px; margin-bottom: 3px;">User already exists.</div>';
                            }
                            elseif(isset($_GET['error']) && $_GET['error'] == 'internet_connection') {
                                echo '<div class="error" style="font-size: 8px; margin-bottom: 3px;">Failed. Try again!.</div>';
                            }
                        ?>
                        <div class="input_field">
                            <form action="signup_process.php" id="form" method="post">
                                <input type="text" name="name" placeholder="Full Name" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="text" name="matric_no" placeholder="Matric No." required>
                                <input type="password" name="password" id="password" placeholder="Password" required>
                                <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility('password')"></i><br>
                                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
                                <i class="fa fa-eye-slash" id="toggleConfirmPassword" aria-hidden="true" onclick="togglePasswordVisibility('confirmPassword')"></i><br>
                                <button type="submit">Sign Up</button>
                            </form>
                            <form action="" class="ck">
                                <input type="checkbox" name="agree" required><small>I agree to the terms and conditions</small> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <script>
        function togglePasswordVisibility(inputId) {
            var inputField = document.getElementById(inputId);
            var toggleIcon = document.getElementById("toggle" + inputId.charAt(0).toUpperCase() + inputId.slice(1));

            if (inputField.type === "password") {
                inputField.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                inputField.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
    <script src="js/validation.js"></script>
</body>
</html>