<?php
//this file will be responsible for letting user communicate with the db and add a topic
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");

$table = 'topic';

$errors = array();
$id = '';
$name = '';
$description = '';

//fetching the topics
$topics = selectAll($table);

if(isset($_POST['add-topic'])){
    adminOnly();
    $errors = validateTopic($_POST);
    if(count($errors)===0){
        unset($_POST['add-topic']);
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Topic created successfully';
        $_SESSION['type'] = 'success';
        //after a topic is added, the admin should be redirected to the manage topic page
        header('location: '. BASE_URL .'/admin/topics/index_topics.php'); 
        exit();
    }
    else{
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}

//since the id is present in the URL, thus it will going to be a GET request
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $topic = selectOne($table, ['id'=>$id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

if(isset($_GET['del_id'])){
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Topic deleted successfully';
    $_SESSION['type'] = 'success';
    //after a topic is deleted, the admin should be redirected to the manage topic page
    header('location: '. BASE_URL .'/admin/topics/index_topics.php'); 
    exit();
}

if(isset($_POST['update-topic'])){
    adminOnly();
    $errors = validateTopic($_POST);
    if(count($errors)===0){
        $id = $_POST['id'];
        unset($_POST['update-topic'], $_POST['id']);
        $topic_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Topic updated successfully';
        $_SESSION['type'] = 'success';
        //after a topic is added, the admin should be redirected to the manage topic page
        header('location: '. BASE_URL .'/admin/topics/index_topics.php'); 
        exit();
    }else{
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}

?>