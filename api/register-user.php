<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');

    include "config.php";
    include "common.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //check email is already exist
    if(check_email_not_exist($email)) {
        $response = array('status' => false, 'message' => 'Email already registered!');
        echo json_encode($response);
    }else {
        $sql = 'INSERT INTO users (name, email, password, created_at) VALUES(
            "'. $name . '",
            "'. $email . '",
            "'. encrypt_password($password) . '",
            "'. get_current_time() .'"
        )';
    
        $result = mysqli_query($conn, $sql) or die('Something went wrong!');
        if($result) {
            $response = array('status' => true, 'message' => 'Register successfull');
            echo json_encode($response);
        }else {
            $response = array('status' => false, 'message' => 'Register failed!');
            echo json_encode($response);
        }
    }
   
    function check_email_not_exist($email) {
        global $conn;
        $sql = "SELECT 8 FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql) or die('Failed to check email');
        if(mysqli_num_rows($result) > 0) {
            return true;
        }
        return false;
    }

    function encrypt_password($password) {
        return $password;
    }
?>