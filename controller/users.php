<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['user_id'];
    $sql =  mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id}");
    $totalUsers = mysqli_num_rows($sql);
    $output = "";
    if($totalUsers == 0){
        $output .= "No users are availabel to chat";
    }elseif($totalUsers > 0){
        include "userData.php";
    }
    echo $output;
?>