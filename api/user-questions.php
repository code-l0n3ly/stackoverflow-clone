<?php
    include "config.php";
    include "common.php";
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');

    $body = json_decode(file_get_contents('php://input'), true);

    $uid = $body['uid'];
    $sql = "SELECT * FROM questions WHERE uid = '$uid'";

    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));

    if(mysqli_num_rows($result) > 0) {

        $raw_questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $questions = array();
        foreach($raw_questions as $question) {
            $question = array_merge(
                $question, 
                array('answers' => get_answer_count($question['qid'])),
                array('user_info' => get_user_info($question['uid']))
            );
            array_push($questions, $question);
        }

        header("HTTP/1.1 200 OK!");
        echo json_encode($questions);

    }else {
        $questions = array('status' =>  false, 'message' => 'No Record Found!');
        header("HTTP/1.1 200 OK");
        echo json_encode($questions);
    }
?>