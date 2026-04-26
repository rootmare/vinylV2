<?php include './includes/header.php'; ?>
<?php
session_start();

//protect page
if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
};

    $host = getenv('MYSQLHOST');
    $port = getenv('MYSQLPORT');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
    $db   = getenv('MYSQLDATABASE');

    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$user_id = $_SESSION['user_id'];

$sql = "SELECT items.id, item_name, category, details, username, `value` FROM items INNER JOIN users ON items.created_by = users.id;";       

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
        <h2>User items</h2>

        <p>Below is a list of items users have submitted. please review them.</p>

        <?php
            if($result->num_rows > 0){
                echo"
                <table>
                    <tr>
                        <td>
                            <strong>Item name<strong>
                        </td>
                        <td>
                            <strong>Category<strong>
                        </td>
                        <td>
                            <strong>Details<strong>
                        </td>
                        <td>
                            <strong>Value<strong>
                        </td>
                        <td>
                           <strong>Edit<strong>
                        </td>
                        <td>
                            <strong>Delete<strong>
                        </td>
                    </tr>
                ";
                while($item = $result->fetch_assoc()){
                    echo "<tr>";
                    // you are working on table dispaly for the fetched data
                    echo "<td>".htmlspecialchars($item['item_name'])."</td>";
                    echo "<td>".htmlspecialchars($item['category'])."</td>";
                    echo "<td>".htmlspecialchars($item['details'])."</td>";
                    echo "<td>£".htmlspecialchars($item['value'])."</td>";

                    echo "<td><a class='edit_button'href='edit_item.php?id=".htmlspecialchars($item['id'])."'>Edit</a> </td>";
                    echo "<td><a class='delete_button'href='user_delete_item.php?id=".htmlspecialchars($item['id'])."'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "<p>You have not submitted any items yet.</p>";
            }
            
            $conn->close();
        ?>
        <P><a class="back_button" href="admin_home.php">Return to Home</a></P>
    </section>
</main>



<?php include './includes/footer.php'; ?>   
