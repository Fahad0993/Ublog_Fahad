<?php include("path.php");?>
<?php include(ROOT_PATH . '/app/controllers/posts.php'); //so that we can access the post from DB

$post_id = $_GET['id'];

if(isset($_GET['id'])){
    $post = selectOne('posts',['id' => $_GET['id']]);
    $comments = getPostComments($_GET['id']);
}

$topicName = selectOne('topic', ['id' => $post['topic_id']]) ;

$topics = selectAll('topic');
$posts = selectAll('posts',['published' => 1]);

$pid = $post['id'];
$views = $post['views'];
//$sql = "update posts set views = $views + 1 where id = $pid;"
update('posts', $pid, ['views' => $views+1]);

function estimateReadingTime($content) {
    // Average reading speed in words per minute
    $wordsPerMinute = 200;   
    // Calculate the number of words in the content
    $wordCount = str_word_count(strip_tags($content));  
    // Calculate the estimated reading time in minutes
    $readingTime = ceil($wordCount / $wordsPerMinute);  
    return $readingTime;
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
    
    <title><?php echo $post['title']; ?> | UBlog</title> <!--improves SEO of our website-->
</head>
<body>
    <?php include(ROOT_PATH . "/app/includes/header.php");?>

    <!--Page Banner-->
    <div class="page-banner">
        <div class="left-section">
            <h2 class="category"><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topicName['id'] . '&name=' .
            $topicName['name'];?>"><?php echo $topicName['name'];?></a></h2>
            <h1><?php echo $post['title'];?></h1>
            <h3>by <a href="author.php?author_id=<?php echo $post['user_id'];?>&author_name=<?php echo $post['username'];?>">
            <?php echo $post['username'];?></a></h3>
            <h3 class="same-line"><i class="fa-solid fa-eye"></i> <?php echo $post['views'];?> views</h3>
            <h3 class="same-line"><i class="fa-brands fa-readme"></i> <?php echo estimateReadingTime(html_entity_decode($post['body']));?> minutes read</h3>
        </div>
        <div class="right-section">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image'];?>" class="image">
        </div>
    </div>
    <!-- //Page Banner-->

    <!--page wrapper-->
    <div class="page-wrapper">

        <!--content section-->
        <div class="content clearfix">
            <!--main content wrapper-->
            <div class="main-content">
            <div class="main-content single">
                <div class="post-content">
                    <?php echo html_entity_decode($post['body']); ?>
                </div>
            </div>
            <!-- Comment section -->
            <div class="main-content comment">
                <h2 class="post-title">Comments (<?php echo count($comments);?>)</h2>
                <div class="comment-form">
                        <form method="post" action="single.php">
                            <input type="hidden" name="parent_id" id="parent_id" value="0" />
				            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
                            <div class="input-container">
                                <input type="text" name="body" class="text-input" placeholder="Add a comment">
                                <button type="submit" id="add-comment" name="add-comment" class="btn btn-big comment-btn">
                                    <i class="fas fa-message"></i>
                                    Add
                                </button>
                            </div>
                        </form>
                </div>

                <!-- Comment body section -->
                <div class="comment-body">
                <?php
                // Group comments by parent_id
                $commentGroups = array();
                foreach ($comments as $comment) {
                    $commentGroups[$comment['parent_id']][] = $comment;
                }
                ?>

                <?php if (!empty($commentGroups[0])): ?>
                <?php foreach ($commentGroups[0] as $parentComment): ?>
                <!-- Display parent comment information -->
                    <div class="comment-entry">
                        <div class="user-info">
                            <i class="fa-solid fa-user"></i>
                            <b><span name="username" style="padding: 0px 10px 0px 0px;"><?php echo $parentComment['username'];?></span></b>
                            <i class="far fa-clock"></i>
                            <span class="comment-time"><?php echo date('F j, Y', strtotime($parentComment['created_at']));?></span>
                        </div>
                        <p class="comment-text"><?php echo $parentComment['body'];?></p>
                        <a class="reply-link">REPLY</a>
                        <?php if(isset($_SESSION['id']) && $_SESSION['id']==$parentComment['user_id']):?>
                            <a href="single.php?comment_id=<?php echo $parentComment['id'];?>" class="delete-link">DELETE</a>
                        <?php endif;?>
                    </div>

                    <?php if (isset($commentGroups[$parentComment['id']])): ?>
                        <?php foreach ($commentGroups[$parentComment['id']] as $childComment): ?>
                            <div class="comment-entry reply">
                            <!-- Display child comment information -->
                            <div class="user-info">
                            <i class="fa-solid fa-user"></i>
                                <b><span name="username" style="padding: 0px 10px 0px 0px;"><?php echo $childComment['username'];?></span></b>
                                <i class="far fa-clock"></i>
                                <span class="comment-time"><?php echo date('F j, Y', strtotime($childComment['created_at']));?></span>
                            </div>
                            <p class="comment-text"><?php echo $childComment['body'];?></p>
                            <a class="reply-link">REPLY</a>
                            <?php if(isset($_SESSION['id']) && $_SESSION['id']==$childComment['user_id']):?>
                                <a href="single.php?comment_id=<?php echo $childComment['id'];?>" class="delete-link">DELETE</a>
                            <?php endif;?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="comment-entry reply form" style="display: none;">
                        <form method="post" action="single.php" class="reply-form">
                            <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $parentComment['id'];?>" />
				            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id;?>" />
                            <input type="hidden" name="parent_username" id="parent_username" value="<?php echo $parentComment['username'];?>"/>
                            <div class="input-container">
                                <input type="text" name="body" id="body" class="text-input" 
                                placeholder="reply to @<?php echo $parentComment['username'];?>">
                                <button type="submit" id="reply-comment" name="reply-comment" class="btn btn-big comment-btn reply-submit-btn">
                                Reply
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>

                </div>
            </div>
            <!--// Comment section -->
            </div>
            <!--//main content wrapper-->
            <!--sidebar-->
            <div class="sidebar single">
                <div class="section popular">
                    <h2 class="section-title">Popular Posts</h2>

                    <?php 
                    //Sorting the posts array based on views in descending order
                    usort($posts, function($a, $b) {
                        return $b['views'] - $a['views'];
                    });

                    //Iterating the top five posts
                    $topPosts = array_slice($posts, 0, 5);

                    foreach($topPosts as $p):?>
                        <div class="post clearfix">
                            <img src="<?php echo BASE_URL . '/assets/images/' . $p['image'];?>" alt="">
                            <a href="single.php?id=<?php echo $p['id'];?>" class="title">
                                <h5><?php echo $p['title'];?></h5>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="section topics">
                    <h2 class="section-title">Topics</h2>
                        <ul>
                            <?php foreach($topics as $topic): ?>
                                <?php if($topic['cadmin_id'] != NULL):?>
                                <li><li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' .
                                $topic['name'];?>">
                                <?php echo $topic['name']; ?>
                                </a></li>
                                <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                </div>
            </div>
            <!--//sidebar-->
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
    <script>
    $(document).ready(function() {
    $('.reply-link').click(function(e) {
        e.preventDefault();

        var $nextElement = $(this).closest('.comment-entry').next();

        // Traverse through the next elements until you find the reply form
        while (!$nextElement.hasClass('comment-entry') || !$nextElement.hasClass('reply') || !$nextElement.hasClass('form')) {
            $nextElement = $nextElement.next();
        }

        // Toggle the reply form
        $nextElement.toggle();
    });
});

    </script>

</body>
</html>