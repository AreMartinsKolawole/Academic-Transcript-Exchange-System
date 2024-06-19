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
                    <h2>Request Verification Code</h2>
                    <?php
                if (isset($_GET['error']) && $_GET['error'] === 'no_user_found') {
                    echo '<div class="error">No user found.</div>';
                }
                ?>
                    <div class="input_field">
                        <form id="myForm" action="process_new_code_request.php" method="post">
                            <input type="email" id="email" name="email" placeholder="Email Address" required><br>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <div id="set" class="set">
                    <a href="../login.php">Log in</a>
                </div>
            </div>
            <div class="right">
                <img src="../img/left.JPG" alt="img">
            </div>
        </div>

    </div>
</body>

</html>