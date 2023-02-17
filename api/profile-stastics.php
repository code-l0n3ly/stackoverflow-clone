<?php
    include "config.php";

    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);

    $uid = $data['uid'];

    $sql = "SELECT CAST(AVG(ratings.rating) AS DECIMAL(5, 1)) AS ratings FROM answers, ratings WHERE answers.aid = ratings.aid AND answers.uid='$uid';";
    $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
    if($result->num_rows > 0) {
        $rating = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array_merge(
            $rating[0],
            get_total_question($uid),
            get_total_answer($uid),
        ));
    }else {
        
    }   

    function get_total_question($uid) {
        global $conn;
        $sql ="SELECT COUNT(qid) AS total_question FROM questions WHERE uid = '$uid'";
        $result = mysqli_query($conn, $sql) or die(sawl("Database Error!", "Something went wrong!", "error"));
        if($result->num_rows > 0) {
            $qiestions = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return ($qiestions[0]);
    }
    function get_total_answer($uid) {
        global $conn;
        $sql ="SELECT COUNT(aid) AS total_answer FROM answers WHERE uid = '$uid'";
        $result = mysqli_query($conn, $sql) or die(sawl("Database Error!", "Something went wrong!", "error"));
        if($result->num_rows > 0) {
            $answers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return ($answers[0]);
    }
?>
