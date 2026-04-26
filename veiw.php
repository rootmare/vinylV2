<?php session_start();?>
<?php

include './includes/header.php';

$page_title = 'view';

    $host = getenv('MYSQLHOST');
    $port = getenv('MYSQLPORT');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
    $db   = getenv('MYSQLDATABASE');

    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

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
        <h2>Customers</h2>
        <?php
            if ($result->num_rows > 0) {
                while($row = $result -> fetch_assoc()){
                echo "<p>";
                echo "<strong>{$row['first_name']} {$row['last_name']}</strong>";
                echo "<br>";
                echo "Email: {$row['email']}";
                echo "<br>";
                echo "<a href = 'edit.php?id={$row['id']}'>Edit </a> | ";
                echo "<a href = 'delete.php?id={$row['id']}'> Delete</a>";
                echo "</p> <hr>";

                }
            }
            
            else{
                echo "<p>No customers found.</p>";
            }
            
            
            $conn->close();
        ?>

        <button class="logout-btn"><a href="logout.php" >Logout</a></button>
    </section>
</main>

<?php
include './includes/footer.php';
?>