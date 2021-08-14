<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
    }

    include_once "header.php";
    include_once "controller/config.php";

    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id= {$user_id}");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }
?>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="user.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="image/<?=$row['image']?>" alt="">
                <div class="details">
                    <span><?=sprintf("%s %s",$row['first_name'],$row['last_name'])?></span>
                    <p><?=$row['status']?></p>
                </div>
            </header>
            <div class="chat-box"></div>
            <form action="#" class="typing-area">
                <div class="mic-area">
                    <i class="fas fa-microphone mic"></i>
                </div>
                <input type="hidden" name="outgoing_id" id="outgoing_id" value="<?=$_SESSION['user_id']?>">
                <input type="hidden" name="incoming_id" id="incoming_id" value="<?=$user_id?>">
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button type="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script src="js/chat.js"></script>
    <script src="js/mic.js"></script>
<?php
    include_once "footer.php";
?>