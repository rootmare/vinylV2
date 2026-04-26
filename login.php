<?php session_start();?>
<?php 
include './includes/header.php' ;

?>

<?php

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pasword = $_POST['password'];

    if($username == 'admin' && $pasword == 'password') {
        $_SESSION['admin'] = true;
        header("location: veiw.php");
        exit();
        
    }
   
    else {
        $error = "Invalid username or password"; 
    }

}

?>

<main>
    <div id="top_box">
        <!-- logo -->
        <div id="spacing">
            <a href="landing_page.php"><img src="./images/logo_music_online.jpg" alt="music online logo" id="logo"></a>
        </div>
        <!-- searching -->
        <div id="searching">
            <form action="search_results.php" method="get" id="search_box">
                <input type="text" id="item_name" name="item_name" placeholder="Search">
            </form>
        </div>
        <!-- login button -->
        <form action="logout.php" method="post" style="text-align:right;">
            <button type="submit">Logout</button>
        </form>
    </div>
    <br>
    <br>
    <section class="customer-form">
        <h2>admin login</h2>
        <?php if($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>

        <a class="back_button" href="user_register.php">register a new user</a>
    </section>
</main>

<?php include './includes/footer.php'; ?>
