<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Sign in</title>
    <link rel="stylesheet" href="../css/style_login.css">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="navlinks">
            <img src="../img/Logo.png" alt="">
            <div class="nav">
                <a href="../index.php">HOME</a>
                <a href="../signup.php">SIGN UP</a>
            </div>
        </div>
        <div class="middle">
            <div class="left">
                <div id="login" class="form_field">
                    <img src="../img/Logo.png" alt="" class="logo"><br><br>
                    <h2>Enter Verification Code</h2>
                    <?php
                if (isset($_GET['error']) && $_GET['error'] === 'incorrect_code') {
                    echo '<div class="error">Incorrect Verification Code.</div>';
                }
                ?>
                    <div class="input_field">
                        <form id="myForm" action="verify_code_process.php" method="post">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                        <input type="text" name="verification_code" placeholder="Enter 6-digit code" required>
                        <button type="submit">Verify</button>
                        </form>
                    </div>
                </div>
                <div id="set" class="set">
                    <a href="../login.php">Log in</a>
                    <a href="./request_new_code.php">Request New Code</a>
                </div>
            </div>
            <div class="right">
                <img src="../img/left.JPG" alt="img">
            </div>
        </div>

    </div>
</body>

</html>