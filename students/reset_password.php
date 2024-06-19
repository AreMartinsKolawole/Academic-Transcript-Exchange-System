<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Sign up</title>
    <link rel="stylesheet" href="../css/style_signup.css">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="navlinks">
            <img src="./img/Logo.png" alt="">
            <div class="nav">
                <a href="../index.php">HOME</a>
                <a href="../login.php">LOG IN</a>
            </div>
        </div>
        <div class="middle">

            <div class="left">
                <img src="../img/left.JPG" alt="img">
            </div>

            <div class="right">
                <div class="right">
                    <div class="form_field"><br><br>
                        <img src="../img/Logo.png" alt=""><br><br>
                        <h3 id="ca">Reset Password</h3>
                        <?php 
                            if(isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
                                echo '<div class="error" style="font-size: 8px; margin-bottom: 3px;">User not found.</div>';
                            }
                            elseif(isset($_GET['error']) && $_GET['error'] == 'internet_connection') {
                                echo '<div class="error" style="font-size: 8px; margin-bottom: 3px;">Failed. Try again!.</div>';
                            }
                        ?>
                        <div class="input_field">
                            <form action="reset_password_process.php" id="form" method="post">
                                <input type="text" name="matric_no" placeholder="Matric No." required><br>
                                <button type="submit" id="submitButton">Reset Password</button>
                            </form>
                        </div>
                        <div id="set" class="set">
                            <a href="../login.php">Log in</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="js/validation.js"></script>
</body>

</html>