<?php include './includes/header.php'; ?>
<?php
session_start();

// Protect page
if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "customer_db");

if ($conn->connect_error) {
    die("database connection failed: " . $conn->connect_error);
}

// gets all the stuff from databases
$sql = "SELECT * FROM users";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

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
        <h2>Site Users</h2>
        <p>Listed users</p>
        <br>
        <?php
            if($result->num_rows > 0){
                echo"
                <table>
                    <tr>
                        <td>
                            <strong>User ID<strong>
                        </td>
                        <td>
                            <strong>Username<strong>
                        </td>
                        <td>
                            <strong>Email<strong>
                        </td>
                        <td>
                            <strong>Password (hashed)<strong>   
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
                    
                    echo "<td>".htmlspecialchars($item['id'])."</td>";
                    echo "<td>".htmlspecialchars($item['username'])."</td>";
                    echo "<td>".htmlspecialchars($item['email'])."</td>";
                    echo "<td>".htmlspecialchars($item['password'])."</td>";

                    echo "<td><a class='edit_button'href='edit_user.php?id=".htmlspecialchars($item['id'])."'>Edit</a> </td>";
                    echo "<td><a class='delete_button'href='delete_user.php?id=".htmlspecialchars($item['id'])."'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                

            }
            else{
                echo "<p>You have not submitted any items yet.</p>";
            }
            
            $conn->close();
        ?>

        <br>

        <a class="back_button" href="admin_home.php">Return to Home</a>
    </section>
</main>

<?php include './includes/footer.php'; ?>