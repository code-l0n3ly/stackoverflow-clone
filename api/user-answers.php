<?php
    include "config.php";
    include "common.php";
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');

    $body = json_decode(file_get_contents('php://input'), true);

    $uid = $body['uid'];
    $sql = "SELECT * FROM answers WHERE uid = '$uid'";

    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));

    if(mysqli_num_rows($result) > 0) {

        $raw_answers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $answers = array();
        foreach($raw_answers as $answer) {
            $answer = array_merge(
                $answer, 
                array('rating' => get_answer_rating($answer['aid'])),
                array('question' => get_answerd_question($answer['qid']))
            );
            array_push($answers, $answer);
        }

        header("HTTP/1.1 200 OK!");
        echo json_encode($answers);

    }else {
        $answers = array('status' =>  false, 'message' => 'No Record Found!');
        header("HTTP/1.1 200 OK");
        echo json_encode($answers);
    }

    function get_answerd_question($qid) {
        global $conn;
        $sql = "SELECT * FROM questions WHERE qid = '$qid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return array_merge(
                $questions[0],
                array('user_info' => get_user_info($questions[0]['uid']))
            );
        }else {
            return array();
        }
    }
?>