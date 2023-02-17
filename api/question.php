<?php
    include "config.php";
    
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');
    $qid = $_POST['qid'];
    $sql = "SELECT * FROM questions WHERE qid = '$qid'";
    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));

    if(mysqli_num_rows($result) > 0) {

        $question = mysqli_fetch_all($result, MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK!");
        echo json_encode($question[0]);

    }else {
        $users = array('status' =>  false, 'message' => 'No Record Found!');
        header("HTTP/1.1 404 Not Found!");
        echo json_encode($users);
    }
?>