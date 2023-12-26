<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/users.php");
$sql = "SELECT name FROM topic WHERE cadmin_id=$id";
$result = $conn -> query($sql);
adminOnly();
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

    <link rel="stylesheet" href="../../assets/css/style.css">

    <!--admin styling-->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    
    <title>Admin Section - Edit User</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

    <!--Admin page wrapper-->
    <div class="admin-wrapper">

        <!--left sidebar-->
        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>
        <!--//left sidebar-->

        <!--Admin content-->
        <div class="admin-content">
            <div class="button-group">
                <a href="create_users.php" class="btn btn-big">Add User</a> 
                <a href="index_users.php" class="btn btn-big">Manage Users</a>              
            </div>

            <div class="content">
                <h2 class="page-title">Edit User</h2>
                <?php include(ROOT_PATH . "/app/helpers/formErrors.php");?>
                <form action="edit_users.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div>
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo $username;?>" class="text-input">
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $email;?>" class="text-input">
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" value="<?php echo $password;?>" class="text-input">
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="passwordConf" value="<?php echo $passwordConf;?>" class="text-input">
                    </div>
                    <div>
                    <?php if($role=="2"):?>
                        <label>Category Admin</label>
                        <select name="category" class="text-input">
                            <?php if($result -> num_rows > 0): ?>
                            <?php foreach($result as $row): ?>                                
                                    <option value="" selected disabled><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                            <?php else:?>  
                                <option value="" disabled>No categories available</option>
                            <?php endif;?>
                        </select>
                    <?php endif;?>
                    </div>
                    <div>
                        <button type="submit" name="update-user" class="btn btn-big">Update User</button>
                    </div>
                </form>
            </div>
        </div>
        <!--//Admin content-->
    </div>
    <!--//Admin page wrapper-->

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!--cdn for ckeditor-->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

    <!--custom script-->
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>