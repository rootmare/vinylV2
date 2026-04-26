<?php session_start();?>
<?php include 'includes/header.php'; ?>
<?php

if(!isset($_SESSION['user_id'])){
    header("Location: admin_login.php");
    exit();
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
                <input type="hidden" name="page" value="admin_home">
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
        <h2>Admin Dashboard</h2>

        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></p>

        

        
        <hr>
        <p><a class="dashboard_button"href="admin_users.php">manage users</a></p>
        <p><a class="dashboard_button" href="items.php">manage Items</a></p>

    </section>
</main>
<?php include 'includes/footer.php'; ?>