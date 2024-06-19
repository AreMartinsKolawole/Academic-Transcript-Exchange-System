<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Sign Up</title>
    <link rel="icon" href="../img/Logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="../img/left.JPG" alt="img">
        </div>
        <div id="signup" class="right">
            <div class="form_field">
                <img style="margin-top: 20px;" src="../img/Logo.png" alt="">
                <h3 style="margin-top: 10px;">Institution - Sign up</h3>
                <div class="input_field">
                    <form action="institution_register_process.php" method="post" onsubmit="return validatePassword()">
                        <input type="text" name="name" placeholder="Institution Name" required><br>
                        <input type="email" name="email" placeholder="Email" required><br>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
                        <div id="passwordRequirements" style="color: #ff0000; font-size: 12px;"></div> <!-- Display password requirements here -->
                        <button class="inst" type="submit">Sign Up</button>
                    </form>
                </div>
                <p>Already have an account? <a href="./institution_login.php">Sign in</a></p>
            </div>
        </div>
    </div>

    <script>

        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;

            if (!passwordPattern.test(password)) {
                document.getElementById("passwordRequirements").innerText = "Password must contain at least 1 number, 1 special character, and be at least 8 characters long.";
                return false;
            }

            if (password !== confirmPassword) {
                document.getElementById("passwordRequirements").innerText = "Passwords do not match.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
