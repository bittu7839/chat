<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
    }
    include_once "controller/config.php";
    include_once "header.php";
    
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id= {$_SESSION['user_id']}");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }
   ?>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="image/<?=$row['image']?>" alt="">
                    <div class="details">
                        <span><?=sprintf("%s %s",$row['first_name'],$row['last_name'])?></span>
                        <p><?=$row['status']?></p>
                    </div>
                </div>
                <a href="controller/logout.php?logout_id=<?=$row['unique_id']?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
            </div>

        </section>
    </div>
    <script src="js/users.js"></script>
   <?php
    include_once "footer.php";
   ?>