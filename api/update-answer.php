<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    
    include "config.php";
    include "common.php";

    $aid = $_POST['aid'];
    $answer = $_POST['answer'];

    $sql = "UPDATE answers SET answer = '$answer' WHERE aid = '$aid'";

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully update your answer!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to update your answer!');
        echo json_encode($response);
    }
?>