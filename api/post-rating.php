<?php
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    
    include "config.php";
    include "common.php";
    $uid = $_POST['uid'];
    $aid = $_POST['aid'];
    $rating = $_POST['rating'];

    $sql = 'INSERT INTO ratings (uid, aid, rating, rated_at) VALUES(
        "'. $uid . '",
        "'. $aid . '",
        "'. $rating . '",
        "'. get_current_time() .'"
    )';

    $result = mysqli_query($conn, $sql) or die('Something went wrong!');
    if($result) {
        $response = array('status' => true, 'message' => 'Successfully post your rating!');
        echo json_encode($response);
    }else {
        $response = array('status' => false, 'message' => 'Failed to post your rating!');
        echo json_encode($response);
    }
?>