<?php
    date_default_timezone_set("Asia/Riyadh");

    function get_answer_count($qid) {
        global $conn;
        $sql = "SELECT COUNT(qid) AS count FROM answers WHERE qid = '$qid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            $answer_count = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $answer_count[0]['count'];
        }else {
            return 0;
        }
    }   
    function get_user_info($uid) {
        global $conn;
        $sql = "SELECT uid, name, email, created_at FROM users WHERE uid = '$uid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $user[0];
        }else {
            return array();
        }
    }

    function get_answer_rating($aid) {
        global $conn;
        $sql = "SELECT CAST(AVG(rating) AS DECIMAL(5, 1))  AS rating FROM ratings WHERE aid = '$aid'";
        $result = mysqli_query($conn, $sql) or die(showSqlErrorMessage("Something went wrong!", "Connection lose with database!"));
        if(mysqli_num_rows($result) > 0) {
            $rating = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if($rating[0]['rating'] == null) {
                return 0;
            }
            return $rating[0]['rating'];

        }else {
            return 0;
        }
    }

    //get current time
    function get_current_time() {
        date_default_timezone_set("Asia/Riyadh");
        $date = date("Y-m-d H:i:s", time());
        return $date;
    }
?>