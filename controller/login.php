<?php
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql =  mysqli_query($conn, "SELECT * FROM users WHERE `email` = '{$email}' AND `password` = '{$password}'");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                $sql2 = mysqli_query($conn, "UPDATE users SET `status` = 'Active' WHERE unique_id = {$row['unique_id']}");
                if ($sql2) {
                    $_SESSION['user_id'] = $row['unique_id'];
                    echo "success";
                }
            }
        }else{
            echo $email . " - This is not valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>