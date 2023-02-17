<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    
    include "config.php";
    include "common.php";
    $uid = $_POST['uid'];
    $aid = $_POST['aid'];
    $comment = $_POST['comment'];

    $sql = 'INSERT INTO comments (uid, aid, comment, commented_at) VALUES(
        "'. $uid . '",
        "'. $aid . '",
        "'. $comment . '",
        "'. get_current_time() .'"
    )';

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully post your comment!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to post your comment!');
        echo json_encode($response);
    }
?>