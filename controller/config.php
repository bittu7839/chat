<?php
    // SERVER PASS lernen@123
    $conn = mysqli_connect('localhost','root','','chat');
    if(!$conn){
        echo "Databse not connected" . mysqli_connect_error();
    }
?>