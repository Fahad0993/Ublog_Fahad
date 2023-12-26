<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");
include(ROOT_PATH . "/app/helpers/validateLogin.php");

$table = 'users';
$admin_users = selectAll($table); //select all users from the table where admin col is true

$errors = array();
$id = '';
$username = '';
$role = '';
$email = '';
$password = '';
$passwordConf = '';

function loginUser($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];// so that the username can be displayed on the navigation bar
    $_SESSION['role'] = $user['role']; //if the dashboard link needs to be displayed or not
    $_SESSION['message'] = 'You are now logged in!!'; 
    $_SESSION['type'] = 'success'; //css-class that is already defined with green color property

    if($_SESSION['role']=="1"){
        header('location: ' . BASE_URL . '/admin/dashboard.php');
    }
    elseif ($_SESSION['role']=="2") {
        header('location: ' . BASE_URL . '/category_admin/dashboard.php');
    }
    elseif ($_SESSION['role']=="3") {
        header('location: ' . BASE_URL . '/blogger/dashboard.php');
    }
    else{
        header('location: ' . BASE_URL . '/index.php');
    }
    exit(); //the execution of the script will end here
}

//creating category admin
if(isset($_POST['create-admin'])){
    $errors = validateUser($_POST);
    // Process the form submission
    $categoryID = $_POST['category'];
    $categoryAdminName = $_POST['username'];
    $categoryAdminEmail = $_POST['email'];
    $categoryAdminPassword = $_POST['password'];
    
    // Assuming you have a function to insert data into the user table
    $categoryAdminID = createUser($categoryAdminName, $categoryAdminEmail, $categoryAdminPassword, "2"); // Role 2 for category admin
    
    if ($categoryAdminID) {
        // Category admin successfully created
        // Update the topic table's cadmin_id column for relevant topics
        $topicsUpdated = updateTopicsCAdmin($categoryID, $categoryAdminID);
        
        if ($topicsUpdated) {
            $_SESSION['message'] = "Category admin and topics updated successfully";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update topics";
            $_SESSION['type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Failed to create category admin";
        $_SESSION['type'] = "error";
    }
    
    header('location: ' . BASE_URL . '/admin/users/index_users.php'); // Redirect back to the admin page
    exit();
}

//registering the user 
if(isset($_POST['register-btn'])){

    $errors = validateUser($_POST);

    if(count($errors) === 0){
        //validation for proper details in registration form

        unset($_POST['register-btn'], $_POST['passwordConf']); //removing unwanted keys from our array using unset()
        $_POST['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT); //password hashing
        

        if(isset($_POST['role'])){
            $userRole = $_POST['role'];
            $user_id = create($table, $_POST); //create() returns an id of the inserted record
            /*$_SESSION['message'] = "Admin user created successfully";
            $_SESSION['type'] = "success";
            header('location: ' . BASE_URL . '/admin/users/index_users.php');*/
            if($userRole == "3") {
                $_SESSION['message'] = "Blogger user created successfully!! Login to confirm";
                $_SESSION['type'] = "success";
                header('location: ' . BASE_URL . '/login.php'); // Redirect to dashboard for role 3
            } elseif ($userRole == "4") {
                $_SESSION['message'] = "Reader registered successfully! Login to confirm";
                $_SESSION['type'] = "success";
                header('location: ' . BASE_URL . '/login.php');
            }
            exit();
        }
        else{
            $_POST['role'] =$user['role'];//reader
            $user_id = create($table, $_POST); //create() returns an id of the inserted record
            $user = selectOne($table,['id'=>$user_id]);       
            //log the user in
            loginUser($user);
        }
    } 
    else{//so that the user's input dont disappear when an error occurs
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

if(isset($_POST['update-user'])){
    adminOnly();
    $errors = validateUser($_POST);

    if(count($errors) === 0){
        $id = $_POST['id'];
        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']); 
        $_POST['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT); 

        //$_POST['admin'] = isset($_POST['admin'])?1:0;
        $count = update($table, $id, $_POST); 
        $_SESSION['message'] = "Admin user updated successfully";
        $_SESSION['type'] = "success";
        header('location: ' . BASE_URL . '/admin/users/index_users.php');
        exit();
    } 
    else{//so that the user's input dont disappear when an error occurs
        $username = $_POST['username'];
        $admin = isset($_POST['admin'])?1:0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

if(isset($_GET['id'])){
    $user = selectOne($table, ['id' => $_GET['id']]);
    $id = $user['id'];
    $username = $user['username'];
    $role = $user['role'];
    $email = $user['email'];
}

//login of user
if(isset($_POST['login-btn'])){
    //validation
    $errors = validateLogin($_POST);

    if(count($errors) === 0){
        //proceed with the login logic
        $user = selectOne($table,['username' => $_POST['username']]);
        if($user && password_verify($_POST['password'], $user['password'])){
            loginUser($user);
        }
        else{
            array_push($errors, 'Wrong credentials, try again');
        }
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
}

if(isset($_GET['delete_id'])){
    adminOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Admin user deleted successfully";
    $_SESSION['type'] = "success";
    header('location: ' . BASE_URL . '/admin/users/index_users.php');
    exit();
}

?>