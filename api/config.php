<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "stackoverflow";

    $conn = mysqli_connect($host, $user, $pass, $db) or die("Something went wrong! Failed to connect with the database!. Contact with us.");

    function showSqlErrorMessage($message) {
        header('location: index.php');
    }
?>