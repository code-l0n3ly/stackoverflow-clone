<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    
    include "config.php";
    include "common.php";

    $qid = $_POST['qid'];

    $sql = "DELETE FROM questions WHERE qid = '$qid'";

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully delete your question!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to update your question!');
        echo json_encode($response);
    }
?>