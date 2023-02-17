<?php
    include "config.php";
    
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"];
    $password = $data["password"];


    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));

    if(mysqli_num_rows($result) > 0) {

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK!");
        echo json_encode($users[0]);

    }else {
        $user = array('status' =>  'false', 'message' => 'Invalid credentials!');
        header("HTTP/1.1 200 OK");
        echo json_encode($user);
    }
?>