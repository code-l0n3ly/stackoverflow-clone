<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');

    include "config.php";
    include "common.php";

    $uid = $_POST['uid'];
    $qid = $_POST['qid'];
    $answer = $_POST['answer'];

    $sql = 'INSERT INTO answers (uid, qid, answer, answered_at) VALUES(
        "'. $uid . '",
        "'. $qid . '",
        "'. $answer . '",
        "'. get_current_time() .'"
    )';

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully post your answer!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to post your answer!');
        echo json_encode($response);
    }
?>