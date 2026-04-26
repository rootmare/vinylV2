<?php session_start();?>
<?php include 'includes/header.php'; ?>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
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
        <h2>User Dashboard</h2>

        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>

        <p>you are logged in and can manage your items.</p>

        
        <hr>
        <p><a href="submit_item.php" class="dashboard_button">Submit New Item</a></p>
        <p><a href="user_item.php" class="dashboard_button">manage My Items</a></p>

    </section>
</main>
<?php include 'includes/footer.php'; ?>