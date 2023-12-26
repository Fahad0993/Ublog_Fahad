<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");
bloggerOnly();
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
    
    <title>Blogger Section - Manage Post</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/bloggerHeader.php"); ?>

    <!--Admin page wrapper-->
    <div class="admin-wrapper">

        <!--left sidebar-->
        <?php include(ROOT_PATH . "/app/includes/bloggerSidebar.php"); ?>
        <!--//left sidebar-->

        <!--Admin content-->
        <div class="admin-content">
            <div class="button-group">
                <a href="create_posts.php" class="btn btn-big">Add Post</a> 
                <a href="index_posts.php" class="btn btn-big">Manage Post</a>              
            </div>

            <div class="content">
                <h2 class="page-title">Manage Post</h2>
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <table>
                    <thead>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th colspan="3">Action</th>
                    </thead>
                    <tbody>
                        <?php $i=1;
                        foreach($posts as $key => $post): ?>
                            <?php if($_SESSION['id']==$post['user_id'] && $post['published']==1):?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $_SESSION['username'];?></td>
                                <td><a href="edit_posts.php?id=<?php echo $post['id']; ?>" class="edit">Edit</a></td>
                                <td><a href="edit_posts.php?delete_id=<?php echo $post['id']; ?>" class="delete">Delete</a></td>
                            </tr>
                            <?php endif;?>
                        <?php endforeach;?>
                    </tbody>
                </table>
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