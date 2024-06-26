<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Admin Signin</title>



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/Logo.png" type="image/x-icon" />

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="admin_login_process.php" method="POST">
            <img class="mb-4" src="../img/Logo.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username."
                    required><br>
                <label for="floatingInput">Username.</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password"
                    required>
                <label for="floatingPassword">Password</label>
            </div><br>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
        </form>



    </main>



</body>

</html>