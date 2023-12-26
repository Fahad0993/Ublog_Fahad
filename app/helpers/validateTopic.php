<?php

function validateTopic($topic){
    $errors = array(); //array variable that will store error messages if any

    if(empty($topic['name'])){
        array_push($errors, 'Topic name is required');
    }

    $existingTopic = selectOne('topic', ['name' => $topic['name']]);
    if($existingTopic){
        if(isset($_POST['update-topic']) && $existingTopic['id'] != $topic['id']){
            array_push($errors, 'Topic with that title already exists');
        }
        if(isset($_POST['add-topic'])){
            array_push($errors, 'Topic with that title already exists');
        }
    }
    
    return $errors;
}

?>