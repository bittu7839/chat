<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
        header("Location: user.php");
    }
?>
<?php include_once "header.php";?>
    <div class="wrapper">
        <section class="form login">
            <header>Welcome to Mis-Chat</header>
            <form action="#">
                <div class="error-text"></div>
                <div class="field input">
                    <label for="">Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Enter new password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Continue to chat">
                </div>

            </form>
            <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
        </section>
    </div>
    <script src="js/show-hide-password.js"></script>
    <script src="js/login.js"></script>
<?php include_once "footer.php";?>
