<?php include("path.php");?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="le-edge">

    <!--font awesome-->

    <script src="https://kit.fontawesome.com/d5a99e9161.js" crossorigin="anonymous"></script>

    <!--google fonts-->

    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!--custom css file-->

    <link rel="stylesheet" href="assets/css/style.css">
    
    <title>Login</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/header.php");?>
    <?php include(ROOT_PATH . "/app/includes/messages.php");?>
    <!--register form-->
    <div class="auth-content">
        <form action="login.php" method="post">
            <h2 class="form-title">Login</h2>
            <?php include(ROOT_PATH . "/app/helpers/formErrors.php");?>
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
            </div>
            <div>
                <button type="submit" name="login-btn" class="btn btn-big">Login</button>
            </div>
            <p>Or <a href="<?php echo BASE_URL . '/register.php';?>">Sign Up</a></p>
        </form>
    </div>


    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    

    <!--custom script-->
    <script src="assets/js/scripts.js"></script>
</body>
</html>