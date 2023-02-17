<?php
    session_start();
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');

    if(isset($_SESSION['user'])) {
        session_destroy();
        header("HTTP/1.1 200 OK!");
        echo json_encode(array('status' => true, 'message' => 'Successfully logout!'));
    }else {
        echo json_encode(array('status' => false, 'message' => 'You are already logout!'));
    }

?>