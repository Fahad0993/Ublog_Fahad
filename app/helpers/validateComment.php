<?php
function validateComment($comment){
    $errors = array(); //array variable that will store error messages if any

    if(empty($comment['body'])){
        array_push($errors, 'Comment cannot be empty!!');
    }
  
    return $errors;
}
?>