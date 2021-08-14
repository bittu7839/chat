<?php
    session_start();
    $base_url = ((isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == "on") ? "https" : "http");
    $base_url .= "://" . $_SERVER ['HTTP_HOST'];

    if(isset($_SESSION['user_id'])){
        include_once "config.php";
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        if($type == "audio"){
            $input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
            $output = $_FILES['audio_data']['name'].".webm"; //letting the client control the filename is a rather bad idea
        
            //move the file from temp name to local folder using $output name
            move_uploaded_file($input,'../audio/'. $output);
            $message = $base_url.'/chat/audio/'.$output;
        }
        
        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages(`outgoing_msg_id`, `incoming_msg_id`, `msg`, `type`) 
                         VALUES ('{$outgoing_id}','{$incoming_id}','{$message}', '{$type}')");

            // Chat list

            $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
            $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
            $output = "";
            $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.incoming_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $checkType = $row['type'];
                    if($checkType == 'text'){
                        if ($row['outgoing_msg_id'] === $outgoing_id) {
                            $output .= '<div class="chat outgoing">
                                            <div class="details">
                                                <p>'.$row['msg'].'</p>
                                            </div>
                                        </div>';
                        }else{
                            $output .= '<div class="chat incoming">
                                            <img src="image/'.$row['image'].'" alt="">
                                            <div class="details">
                                                <p>'.$row['msg'].'</p>
                                            </div>
                                        </div>';
                        }
                    }elseif ($checkType == 'audio') {
                        if ($row['outgoing_msg_id'] === $outgoing_id) {
                            $output .= '<div class="chat outgoing">
                                            <div class="details">
                                                <audio controls>
                                                    <source src="'.$row['msg'].'" type="audio/webm">
                                                </audio>
                                            </div>
                                        </div>';
                        }else{
                            $output .= '<div class="chat incoming">
                                            <img src="image/'.$row['image'].'" alt="">
                                            <div class="details">
                                                <audio controls>
                                                    <source src="'.$row['msg'].'" type="audio/webm">
                                                </audio>
                                            </div>
                                        </div>';
                        }
                    }
                }
                echo $output;
            }
        }
    }else{
        header('Location: ../login.php');
    }
?>