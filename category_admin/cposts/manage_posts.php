<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");

$categoryAdminId = $_SESSION['id'];
$query = "SELECT p.* FROM posts as p
          JOIN users as u ON p.user_id = u.id
          WHERE p.topic_id IN 
          (SELECT id FROM topic WHERE cadmin_id = $categoryAdminId)
          AND p.published = 0 AND u.role = '3'";
$result = mysqli_query($conn, $query);

categoryAdminOnly();
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
    
    <title>CAdmin Section - Manage Post</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/cadminHeader.php"); ?>

    <!--Admin page wrapper-->
    <div class="admin-wrapper">

        <!--left sidebar-->
        <?php include(ROOT_PATH . "/app/includes/cadminSidebar.php"); ?>
        <!--//left sidebar-->

        <!--Admin content-->
        <div class="admin-content">

            <div class="content">
                <h2 class="page-title">Approve / Reject Blogs</h2>
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
                    if($result):?>
                        <?php foreach($result as $row):?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['username'];?></td>
                                <td><a href="../../single.php?id=<?php echo $row['id'];?>" class="edit" style="color:blue;">View</a></td>
                                <td><a href="../posts/edit_posts.php?published=1&p_id=<?php echo $row['id'];?>" class="publish" style="color:green;">
                                Approve</a></td>
                                <td><a href="index_posts.php?delete_id=<?php echo $row['id']; ?>" class="delete">Reject</a></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
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