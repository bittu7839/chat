<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['user_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $output = "";
    $sql =  mysqli_query($conn, "SELECT * FROM users  WHERE NOT unique_id = {$outgoing_id} AND (first_name LIKE '%{$searchTerm}%' OR last_name LIKE '%{$searchTerm}%')");
    if(mysqli_num_rows($sql) > 0){
        include "userData.php";
    }else{
        $output .= "No user found";
    }
    echo $output;
?>