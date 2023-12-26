<?php

session_start(); //written here so that many other file are going to be using a session

require('connect.php'); //so that $conn object becomes accessible to us

function print_val($value){ //to be deleted
    echo "<pre>",print_r($value, true), "</pre>";
    //the 'true' argument get rid of the trailing 1 created by the print_r() function
    die();
}

function executeQuery($sql, $data){
    global $conn;
    $stmt = $conn->prepare($sql);//prepared statements are used to prevent sql injections
    $values = array_values($data); //array without the keys, just values
    $types = str_repeat('s',count($values));
    $stmt->bind_param($types,...$values);//used spread operator i.e $admin, $username jaise ko lekar chalega
    $stmt->execute();
    return $stmt;
}

function selectAll($table, $conditions = []){
    global $conn;
    $sql = "SELECT * FROM $table";
    if(empty($conditions)){
        //prepared statements will be used for security purposes
        $stmt = $conn->prepare($sql);
        $stmt->execute(); //query will be executed
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        //get_result() -> gets all the results from the query fired.
        //fetch_all()->to get all the record from the database in the form of an associative array [array with named keys and value]
        return $records;
    }
    else{
        //return records that match the given conditions...
        //$sql = "SELECT * FROM $table WHERE username='Nida' AND admin=1";
        $i=0;
        foreach($conditions as $key => $value){
            if($i==0){
                $sql = $sql . " WHERE $key=?";//admin=1
            }
            else{
                $sql = $sql . " AND $key=?";//username=Nida...
            }   
            $i++;       
        }
        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    
}

function selectOne($table, $conditions){//will only get an array containing items, instead of array of arrays
    global $conn;
    $sql = "SELECT * FROM $table";
    $i=0;
    foreach($conditions as $key => $value){
        if($i==0){
            $sql = $sql . " WHERE $key=?";
        }
        else{
            $sql = $sql . " AND $key=?";
        }   
        $i++;       
    }
    $sql = $sql . " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();//fetch_assoc will return the record as an associative array
    return $records;   
}

function create($table, $data){
    global $conn;
    // ** $sql = "INSERT INTO users SET username=?, admin=?, email=?, password=?" [SET clause is used here]
    $sql = "INSERT INTO $table SET";
    $i = 0;
    foreach($data as $key => $value){
        if($i==0){
            $sql = $sql . " $key=?";
        }
        else{
            $sql = $sql . ", $key=?";
        }   
        $i++; 
    }
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

function createUser($name, $email, $password, $role) {
    // Replace 'your_database_connection_function' with your actual database connection function
    global $conn;

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the insert query
    $insertQuery = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssi", $name, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        return $stmt->insert_id; // Return the ID of the newly inserted user
    } else {
        return false; // Insertion failed
    }
}


function updateTopicsCAdmin($categoryID, $categoryAdminID) {
    // Replace 'your_database_connection_function' with your actual database connection function
    global $conn;
    
    $updateQuery = "UPDATE topic SET cadmin_id = ? WHERE id = ?";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("is", $categoryAdminID, $categoryID);
    
    if ($stmt->execute()) {
        return true; // Update successful
    } else {
        return false; // Update failed
    }
}


function update($table, $id, $data){
    global $conn;
    // ** $sql = "UPDATE users SET username=?, admin=?, email=?, password=? WHERE id=?" [SET clause is used here]
    $sql = "UPDATE $table SET";
    $i = 0;
    foreach($data as $key => $value){
        if($i==0){
            $sql = $sql . " $key=?";
        }
        else{
            $sql = $sql . ", $key=?";
        }   
        $i++; 
    }
    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;//if it returns 1 or more then our command was successfully fired
}

function delete($table, $id){
    global $conn;
    // ** $sql = "DELETE FROM users WHERE id=?"
    $sql = "DELETE FROM $table WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, ['id'=>$id]);
    return $stmt->affected_rows;
}

function getPublishedPost(){
    global $conn;
    //getting username and topic name with the help of JOIN clause
    $sql = "SELECT p.*, u.username, t.name FROM posts AS p 
    JOIN users AS u ON p.user_id=u.id 
    JOIN topic AS t ON p.topic_id=t.id 
    WHERE p.published=?
    ORDER BY p.created_at DESC";
    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getPostComments($post_id){
    global $conn;
    // Selecting comments based on the provided post_id
    $sql = "SELECT * FROM comments
    WHERE post_id = ?";
    
    $stmt = executeQuery($sql, ['post_id' => $post_id]);
    $comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $comments;
}

function get_posts_with_username(){
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p 
    JOIN users AS u ON p.user_id=u.id  
    ORDER BY p.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getPostsByTopic($topic_id){
    global $conn;
    //getting username and topic name with the help of JOIN clause
    $sql = "SELECT p.*, u.username, t.name FROM posts AS p 
    JOIN users AS u ON p.user_id=u.id 
    JOIN topic AS t ON p.topic_id=t.id 
    WHERE p.published=? AND p.topic_id = ?
    ORDER BY p.created_at DESC";
    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function searchPost($term){
    $match = '%' . $term . '%';
    global $conn;
    //getting username and topic name with the help of JOIN clause
    $sql = "SELECT p.*, u.username, t.name FROM posts AS p 
    JOIN users AS u ON p.user_id=u.id
    JOIN topic AS t ON p.topic_id=t.id 
    WHERE p.published=? 
    AND p.title LIKE ? OR t.name LIKE ?
    ORDER BY p.created_at DESC"; //? = $match
    $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'name' => $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

?>