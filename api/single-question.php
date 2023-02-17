<?php
    include "config.php";
    include "common.php";
    
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);
    
    $qid = $data['qid'];
    $sql = "SELECT * FROM questions WHERE qid = '$qid'";
    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));

    if(mysqli_num_rows($result) > 0) {

        $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $raw_answers = get_answers($qid);
        
        
        $answers = array();
        foreach($raw_answers as $answer) {
            $answer = array_merge(
                $answer, 
                array(
                    'user_info' => get_user_info($answer['uid']), 
                    'rating' => get_answer_rating($answer['aid']),
                    'comments' => get_answer_comments($answer['aid']),
                )
            );
            array_push($answers, $answer);
        }

        header("HTTP/1.1 200 OK!");

        $question = array_merge(
            array_merge(
                array('question' => $questions[0]), 
                array('user_info' => get_user_info($questions[0]['uid']))
            ),
            array('answers' => $answers));
        echo json_encode($question);

    }else {
        $questions = array('status' =>  false, 'message' => 'No Record Found!');
        echo json_encode($questions);
    }

    function get_answers($qid) {
        global $conn;
        $sql = "SELECT * FROM answers WHERE qid = '$qid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            
            $answers = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $answers;

        }else {
            return array();
        }
    }

    function get_answer_comments($aid) {
        date_default_timezone_set("Asia/Riyadh");
        global $conn;
        $sql = "SELECT * FROM comments WHERE aid = '$aid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            
            $raw_comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $comments = array();
            foreach($raw_comments as $comment) {
                array_push($comments, array_merge($comment, get_user_info($comment['uid'])));
            }
            return $comments;

        }else {
            return array();
        }
    }

?>