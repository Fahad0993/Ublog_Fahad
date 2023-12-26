<?php

function usersOnly($redirect = '/index.php'){
    if(empty($_SESSION['id'])){
        //checks if the user is not logged in
        $_SESSION['message'] = 'You need to login first to access this page!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function adminOnly($redirect = '/index.php'){
    if(empty($_SESSION['id']) || $_SESSION['role']!="1"){
        //checks if the user is not admin user
        $_SESSION['message'] = 'You need to be an admin user to access this page!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function bloggerOnly($redirect = '/index.php'){
    if(empty($_SESSION['id']) || $_SESSION['role']!="3"){
        //checks if the user is not admin user
        $_SESSION['message'] = 'You need to be a blogger to access this page!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function categoryAdminOnly($redirect = '/index.php'){
    if(empty($_SESSION['id']) || $_SESSION['role']!="2"){
        //checks if the user is not admin user
        $_SESSION['message'] = 'You need to be a category admin to access this page!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function admin_cadmin_bloggerOnly($redirect = '/index.php'){
    if(empty($_SESSION['id']) || $_SESSION['role']=="4"){
        //checks if the user is not admin user
        $_SESSION['message'] = 'You need to be an admin/blogger user to access this page!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function loggedInUsersOnly($redirect = '/index.php'){
    if(empty($_SESSION['id'])){
        $_SESSION['message'] = 'You need to be logged in to access this feature!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function guestsOnly($redirect = '/index.php'){
    if(empty($_SESSION['id'])){
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

?>