<?php

function validateUser($user){
    $errors = array(); //array variable that will store error messages if any

    if(empty($user['username'])){
        array_push($errors, 'Username is required');
    }

    if(empty($user['email'])){
        array_push($errors, 'Email is required');
    }

    if(empty($user['password'])){
        array_push($errors, 'Password is required');
    }

    if($user['passwordConf'] !== $user['password']){
        array_push($errors, 'Password do not match');
    }

    $existingUser = selectOne('users', ['email' => $user['email']]);
    if($existingUser){
        if(isset($_POST['update-user']) && $existingUser['id'] != $user['id']){
            array_push($errors, 'User with that email already exists');
        }
        if(isset($_POST['create-admin'])){
            array_push($errors, 'User with that email already exists');
        }
    }
    
    return $errors;
}

?>