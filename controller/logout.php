<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include_once "config.php";
        $logoutId = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logoutId)){
            $status = "Offline";
            $sql = mysqli_query($conn, "UPDATE users SET `status` = '{$status}' WHERE unique_id = {$logoutId}");
            if($sql){
                session_destroy();
                session_unset($_SESSION['user_id']);
                header("Location: ../login.php");
            }
        }else{
            header("Location: ../user.php");
        }
    }else{
        header("Location: ../login.php");
    }
?>