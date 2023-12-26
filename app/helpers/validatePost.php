<?php
function validatePost($post){
    $errors = array(); //array variable that will store error messages if any

    if(empty($post['title'])){
        array_push($errors, 'Post title is required');
    }

    if(empty($post['body'])){
        array_push($errors, 'Body for the post is required');
    }

    if(empty($post['topic_id'])){
        array_push($errors, 'Please select a topic');
    }

    $existingPost = selectOne('posts', ['title' => $post['title']]);
    if($existingPost){
        if(isset($_POST['update-post']) && $existingPost['id'] != $post['id']){
            array_push($errors, 'Post with that title already exists');
        }
        if(isset($_POST['add-post'])){
            array_push($errors, 'Post with that title already exists');
        }
    }
  
    return $errors;
}
?>