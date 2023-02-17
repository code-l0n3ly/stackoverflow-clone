<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    
    include "config.php";
    include "common.php";

    $qid = $_POST['qid'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE questions SET title = '$title', description = '$description' WHERE qid = '$qid'";

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if(mysqli_affected_rows($conn) > 0) {
        $response = array('status' => true, 'message' => 'Successfully update your question!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to update your question!');
        echo json_encode($response);
    }
?>