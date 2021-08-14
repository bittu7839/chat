<?php
    session_start();
    include_once "config.php";
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)){
        // Check email valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // let's check email already exits in the database or not
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                echo $email . " - This email already exist!";
            }else{
                // let's check file upload or not
                if(isset($_FILES['image'])){
                    $imgName = $_FILES['image']['name']; //getting uploaded img name
                    $imgType = $_FILES['image']['type']; //getting image type
                    $imgTmpName = $_FILES['image']['tmp_name']; //this tempoarary name is used to save file in our folder

                    // let's explode image get the last extension like jpg png
                    $imgExplode = explode('.', $imgName);
                    $imgExtension = end($imgExplode); // Here get the file extension

                    $extension = ['png', 'jpg', 'jpeg', 'webp']; // Valid extension
                    if(in_array($imgExtension, $extension) === true){
                        $time = time();
                        $newImgName = $time.$imgName;
                        if(move_uploaded_file($imgTmpName, "../image/".$newImgName)){
                            $status = "Active";
                            $randomId = rand(time(), 10000000);
                            $sql2 = mysqli_query($conn, "INSERT INTO `users`(`unique_id`, `first_name`, `last_name`, `email`, `password`, `image`, `status`) 
                                VALUES({$randomId}, '{$firstName}', '{$lastName}', '{$email}', '{$password}', '{$newImgName}', '{$status}')");
                            if($sql2){
                                $sql3 =  mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['user_id'] = $row['unique_id'];
                                    echo "success";
                                }
                            }else{
                                echo "Something went wrong";
                            }
                        }else{
                            echo "File not uploaded";
                        }
                    }else{
                        echo "Please select an image file - jpeg, jpg, png, webp";
                    }
                }else{
                    echo "Please select on Image files!";
                }
            }
        }else{
            echo $email . " - This is not valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>