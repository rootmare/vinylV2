<?php session_start();?>
<?php include './includes/header.php'; ?>
<?php
    session_start();



    $host = getenv('MYSQLHOST');
    $port = getenv('MYSQLPORT');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
    $db   = getenv('MYSQLDATABASE');

    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }



    $sql = "SELECT `image`, items.id, item_name, category, details, username, `value` FROM items INNER JOIN users ON items.created_by = users.id;";       

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    };


    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
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
                <input type="hidden" name="page" value="landing_page">
            </form>
        </div>
        <!-- hereo for cat -->
        <!-- login button -->
        <div>
            <a class='log_button' href='user_login.php'>Login</a>
        </div>
    </div>
    <br>
    <br>

    <section class="customer-form_landing">
        <div id="item_header">
            <h3>Available Items</h3>
        </div>

        <?php
            if($result->num_rows > 0){
                
                while($item = $result->fetch_assoc()){
                    echo "<div class='item-card'>";
                    // you are working on table dispaly for the fetched data
                    echo "<img class=\"item-image\" src=\"" . $item['image'] . "\" alt=\"" . $item['item_name'] . " cover image\" />";
                    // don't know why the back slashs are needed but without them the image won't show up
                    echo "<br>";
                    echo "".htmlspecialchars($item['item_name']);
                    echo "<br>";
                    echo "£".htmlspecialchars($item['value']);
                    echo "<br><br>";
                    echo "<a class='edit_button'href='play_item.php?id=".htmlspecialchars($item['id'])."'>play</a> ";
                    echo "<br><br>";
                    echo "<a class='edit_button'>buy</a>";// not to be implemented in this project but just to show the idea of how the page will look like
                    echo "</div>";
                }
                
                
                

            }
            else{
                echo "<p>You have not submitted any items yet.</p>";
            }
            
            $conn->close();
        ?>
        
    </section>
</main>



<?php include './includes/footer.php'; ?>   
