<?php include './includes/header.php'; ?>

<?php
    $host = getenv('MYSQLHOST');
    $port = getenv('MYSQLPORT');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
    $db   = getenv('MYSQLDATABASE');

    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Get ID from URL
$id = $_GET['id'] ?? 0;

// Prepare secure query
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$item = $result->fetch_assoc();

$stmt->close();
$conn->close();
session_start();



$conn = new mysqli("localhost", "root", "", "customer_db");

if ($conn->connect_error) {
    die("database connection failed: " . $conn->connect_error);
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
        <h2>Item Details</h2>

        <?php if ($item): ?>

            <?php echo "<img class=\"item-image\" src=\"" . $item['image'] . "\" alt=\"" . $item['item_name'] . " cover image\" />"; ?>

            <p><strong>Item Name: </strong><?php echo htmlspecialchars($item['item_name']); ?></p>

            <p><strong>Category: </strong><?php echo htmlspecialchars($item['category']); ?></p>

            <p><strong>Description: </strong><?php echo nl2br(htmlspecialchars($item['details'])); ?></p>

            <p><strong>Value: £</strong><?php echo htmlspecialchars($item['value']); ?></p>



        <?php else: ?>
            <p>No item found with this ID.</p>
        <?php endif; ?>

        <a class="back_button" href="landing_page.php" >Landing Page</a>

        

    </section>
</main>

<?php include './includes/footer.php'; ?>