<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-login mt-4">
                <h4>Welcome Back!</h4>
                <form action="backend/loginauth.php" method="post">
                    <input type="text" id="email" name="email" class="form-control my-2" placeholder="Email" required autofocus>
                    <input type="password" id="password" name="password" class="form-control my-2" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script src="frontend/js/bootstrap.min.js"></script>
</body>
</html>