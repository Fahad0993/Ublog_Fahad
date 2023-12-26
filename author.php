<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$posts = array();
$postsTitle = 'Recent Posts';

if(isset($_GET['t_id'])){
    $posts = getPostsByTopic($_GET['t_id']);
    $postsTitle = "You searched for posts under '" . $_GET['name'] . "'";
}
else if(isset($_POST['search-term'])){
    $postsTitle = "You searched for '" . $_POST['search-term'] . "'";
    $posts = searchPost($_POST['search-term']);
}
else if(isset($_GET['author_id']) && isset($_GET['author_name'])){
    $authorName = $_GET['author_name'];
    $authorPosts = selectAll('posts',['user_id' => $_GET['author_id'], 'published' => 1]);
    $reversedPosts = array_reverse($authorPosts);
}
else{
    $posts = getPublishedPost(); //fetching only published post from the DB
}

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
    
    <title>UBlog</title>
</head>
<body>
    <!--navigation bar: logo(text),nav menu,menu icon-->
    <?php include(ROOT_PATH . "/app/includes/header.php");?>
    <?php include(ROOT_PATH . "/app/includes/messages.php");?>

    <!--page wrapper-->
    <div class="page-wrapper">

        <!--content section-->
        <div class="content clearfix">
            <!--main content-->
            <div class="main-content">
                <h1 class="recent-post-title" style="text-align: center;">Blogs Written by <?php echo $authorName;?></h1>

                <?php foreach($reversedPosts as $post):?>                
                    <div class="post clearfix">
                        <img src="<?php echo BASE_URL . '/assets/images/' . $post['image'];?>" alt="" class="post-image">
                        <div class="post-preview">
                            <h2><a href="single.php?id=<?php echo $post['id'];?>"><?php echo $post['title'];?></a></h2>
                            &nbsp;&nbsp;<i class="far fa-user"></i>&nbsp;<?php echo $post['username'];?>
                            &nbsp;
                            <i class="far fa-calendar"></i>&nbsp;<?php echo date('F j, Y', strtotime($post['created_at']));?>
                            <p class="preview-text">
                                <?php echo html_entity_decode(substr($post['body'], 0, 250) . '...');?>
                            </p>
                            <a href="single.php?id=<?php echo $post['id'];?>" class="btn read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <!--//main content-->
            <div class="sidebar">
                <div class="section search">
                    <h2 class="section-title">Search</h2>
                    <form action="index.php" method="post">
                        <input type="text" name="search-term" class="text-input" placeholder="Search Blogs">
                    </form>
                </div>
                <div class="section topics">
                    <h2 class="section-title">Topics</h2>
                        <ul>
                            <?php foreach($topics as $key => $topic): ?>
                                <?php if($topic['cadmin_id'] != NULL):?>
                                <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' .
                                $topic['name'];?>">
                                <?php echo $topic['name']; ?>
                                </a></li>
                                <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                </div>
            </div>
        </div>
        <!--//content section-->

    </div>
    <!--//page wrapper-->

    <!--footer-->
    <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    <!--//footer-->

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!--slick carousal-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!--custom script-->
    <script src="assets/js/scripts.js"></script>
</body>
</html>