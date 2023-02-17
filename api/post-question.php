<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');

    include "config.php";
    include "common.php";

    $uid = $_POST['uid'];
    $question = $_POST['question'];
    $description = $_POST['description'];

    $sql = 'INSERT INTO questions (uid, title, description, asked_at) VALUES(
        "'. $uid. '",
        "'. $question. '",
        "'. $description . '",
        "'. get_current_time() .'"
    )';

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully post your question!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to post a question!');
        echo json_encode($response);
    }
?>