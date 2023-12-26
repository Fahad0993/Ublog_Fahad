<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'ublog_fahad';

#creating instance of our connection
$conn = new MySQLi($host, $user, $pass, $db_name); #object used for making any database call, here, it connects to ublog db

if($conn->connect_error){
    die('Database connection error: '.$conn->connect_error);
}

?>