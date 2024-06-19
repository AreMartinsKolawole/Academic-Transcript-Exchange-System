<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Sign in</title>
    <link rel="stylesheet" href="../css/style_login.css">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="navlinks">
            <img src="./img/Logo.png" alt="">
            <div class="nav">
                <a href="../index.php">HOME</a>
                <a href="./institution_register.php">SIGN UP</a>
            </div>
        </div>
        <div class="middle">
            <div class="left">
                <div id="login" class="form_field">
                    <img src="../img/Logo.png" alt="" class="logo">
                    <h3>Institution - Log in </h3>

                <!-- <div class="error" id="errorMessage"></div> -->

                <div class="input_field">
                    <form action="institution_login_process.php" method="post" onsubmit="return validateForm()">
                        <input type="email" name="email" placeholder="Email" required><br>
                        <input type="password" id="password" name="password"  placeholder="Password">  
                        <i class="fa fa-eye-slash" id="togglePassword" aria-hidden="true" onclick="togglePasswordVisibility('password')"></i>
                        <button class="inst" type="submit" id="submitButton">Log in</button>
                    </form>
                </div>
                    <div class="set">
                        <a href="../institution/reset_password.php">Reset password</a>
                    </div>
                </div>
            </div>
            <div class="right">
                <img src="../img/left.JPG" alt="img">
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
</body>
</html>