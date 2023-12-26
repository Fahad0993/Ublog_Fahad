<?php
//this file will be responsible for letting user communicate with the db and add a post
//include(ROOT_PATH . "/app/controllers/topics.php");
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");
include(ROOT_PATH . "/app/helpers/validateComment.php");

$table = 'posts';

$topics = selectAll('topic');
$posts = selectAll($table);

$errors = array();
$id = '';
$user_id = '';
$title = '';
$body = '';
$topic_id = '';
$published = '';
$views = '';

if(isset($_GET['id'])){
    $post = selectOne($table, ['id'=>$_GET['id']]);

    $id = $post['id'];
    $user_id = $post['user_id'];
    $title = $post['title'];
    $body = $post['body'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
    $views = $post['views'];
}

if(isset($_GET['delete_id'])){
    admin_cadmin_bloggerOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Post deleted successfully";
    $_SESSION['type'] = "success";
    //after a user creates the post, they should be redirected to manage posts page
    if($_SESSION['role']=="1"){
        header('location: '. BASE_URL . '/admin/posts/index_posts.php');
    }
    elseif($_SESSION['role']=="2"){
        header('location: '. BASE_URL . '/category_admin/posts/index_posts.php');
    }
    elseif($_SESSION['role']=="3"){
        header('location: '. BASE_URL . '/blogger/posts/index_posts.php');
    }
    exit();
}

//deleting the comment
if (isset($_GET['comment_id'])) {
    loggedInUsersOnly();  
    // Get the comment's parent_id before deleting it
    $comment_id = $_GET['comment_id'];
    $comment = selectOne('comments', ['id' => $comment_id]);
    $parent_id = $comment['parent_id'];

    // Delete the comment
    $count = delete('comments', $comment_id);
    $sql = "DELETE FROM comments WHERE parent_id=?";
    $stmt = executeQuery($sql, ['parent_id' => $comment_id]);

    $_SESSION['message'] = "Comment deleted successfully";
    $_SESSION['type'] = "success";
    // Redirect back to the appropriate location
    header('location: ' . BASE_URL . '/index.php'); // Update with the correct URL
    exit();
}


if(isset($_GET['published']) && isset($_GET['p_id'])){
    admin_cadmin_bloggerOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    //updating the published field on the post

    $count = update($table, $p_id, ['published' => $published]);

    $_SESSION['message'] = "Post published state changed successfully";
    $_SESSION['type'] = "success";
    if($_SESSION['role']=="1"){
        header('location: '. BASE_URL . '/admin/posts/index_posts.php');
    }
    elseif($_SESSION['role']=="2"){
        header('location: '. BASE_URL . '/category_admin/posts/index_posts.php');
    }
    elseif($_SESSION['role']=="3"){
        header('location: '. BASE_URL . '/blogger/posts/index_posts.php');
    }
    exit();
}

if(isset($_POST['add-post'])){
    admin_cadmin_bloggerOnly();
    $errors = validatePost($_POST);

    if(!empty($_FILES['image']['name'])){
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name; //the directory in which we want to store our image
        
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination); //return a boolean

        if($result){
            $_POST['image'] = $image_name;
        }
        else{
            array_push($errors, "Failed to upload image");
        }

    }
    else{
        array_push($errors, "Post image is required");
    }

    if(count($errors) == 0){
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published'])?1:0;//?true condition:false condition
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['username'] = $_SESSION['username'];
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Post created successfully";
        $_SESSION['type'] = "success";
        //after a user creates the post, they should be redirected to manage posts page
        if($_SESSION['role']=="1"){
            header('location: '. BASE_URL . '/admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="2"){
            header('location: '. BASE_URL . '/category_admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="3"){
            header('location: '. BASE_URL . '/blogger/posts/index_posts.php');
        }
        exit();
    }
    else{
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published'])?1:0; //since checkbox work differently
    }
}

//for adding comments
if(isset($_POST['add-comment'])){
    loggedInUsersOnly();
    $errors = validateComment($_POST);

    if(count($errors) == 0){
        unset($_POST['add-comment']);
        $_POST['parent_id'] = $_POST['parent_id'];
        $_POST['post_id'] = $_POST['post_id'];
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['username'] = $_SESSION['username'];
        $_POST['body'] = $_POST['body'];
        $post_id = create('comments', $_POST);
        $_SESSION['message'] = "Comment created successfully";
        $_SESSION['type'] = "success";

        header('location: '. BASE_URL . '/index.php');
        exit();
    }
    else{
        $_SESSION['message'] = "Comment body cannot be empty";
        $_SESSION['type'] = "error";
        header('location: '. BASE_URL . '/index.php');
        exit();
    }
}

//for reply to comments
if(isset($_POST['reply-comment'])){
    loggedInUsersOnly();
    $errors = validateComment($_POST);

    if(count($errors) == 0){
        unset($_POST['reply-comment']);
        $_POST['parent_id'] = $_POST['parent_id'];
        $_POST['post_id'] = $_POST['post_id'];
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['username'] = $_SESSION['username'];
        $_POST['body'] = "@". $_POST['parent_username'] . " " . $_POST['body'];
        unset($_POST['parent_username']);
        $post_id = create('comments', $_POST);
        $_SESSION['message'] = "Comment reply created successfully";
        $_SESSION['type'] = "success";

        header('location: '. BASE_URL . '/index.php');
        exit();
    }
    else{
        $_SESSION['message'] = "Comment body cannot be empty";
        $_SESSION['type'] = "error";
        header('location: '. BASE_URL . '/index.php');
        exit();
    }
}


//blogger approval function
if(isset($_POST['send-request'])){
    admin_cadmin_bloggerOnly();
    $errors = validatePost($_POST);

    if(!empty($_FILES['image']['name'])){
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name; //the directory in which we want to store our image
        
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination); //return a boolean

        if($result){
            $_POST['image'] = $image_name;
        }
        else{
            array_push($errors, "Failed to upload image");
        }

    }
    else{
        array_push($errors, "Post image is required");
    }

    if(count($errors) == 0){
        unset($_POST['send-request']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = 0;//?true condition:false condition

        //removing tags from our body element for more security
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['username'] = $_SESSION['username'];
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Post request submitted successfully";
        $_SESSION['type'] = "success";
        //after a user creates the post, they should be redirected to manage posts page
        if($_SESSION['role']=="1"){
            header('location: '. BASE_URL . '/admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="2"){
            header('location: '. BASE_URL . '/category_admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="3"){
            header('location: '. BASE_URL . '/blogger/posts/index_posts.php');
        }
        exit();
    }
    else{
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published'])?1:0; //since checkbox work differently
    }
}

//update post
if(isset($_POST['update-post'])){
    admin_cadmin_bloggerOnly();
    $errors = validatePost($_POST);

    if(!empty($_FILES['image']['name'])){
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name; 
        
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination); 

        if($result){
            $_POST['image'] = $image_name;
        }
        else{
            array_push($errors, "Failed to upload image");
        }

    }
    else{
        array_push($errors, "Post image is required");
    }

    if(count($errors) == 0){
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        //$_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published'])?1:0;

        //removing tags from our body element for more security
        $_POST['body'] = htmlentities($_POST['body']);

        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Post updated successfully";
        $_SESSION['type'] = "success";
        //after a user creates the post, they should be redirected to manage posts page
        if($_SESSION['role']=="1"){
            header('location: '. BASE_URL . '/admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="2"){
            header('location: '. BASE_URL . '/category_admin/posts/index_posts.php');
        }
        elseif($_SESSION['role']=="3"){
            header('location: '. BASE_URL . '/blogger/posts/index_posts.php');
        }
        exit();
    }
    else{
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published'])?1:0;
    }
}

?>