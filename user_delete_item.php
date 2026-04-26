<?php session_start();?>
<?php include './includes/header.php'; ?>
<?php


// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

    $host = getenv('DB_HOST');
$port = intval(getenv('DB_PORT'));
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

$conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$user_id = $_SESSION['user_id'];
$item_id = $_GET['id'];
$error = "";
$success = "";

// Fetch item to edit
$stmt = $conn->prepare("
    SELECT item_name, category, details, value
    FROM items
    WHERE id = ? 
");
$stmt->bind_param("i", $item_id );
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Check if item belongs to this user
if ($result->num_rows !== 1) {
    die("Item not found or access denied.");
}

$item = $result->fetch_assoc();

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    

    
        // deletes item
        $stmt = $conn->prepare("
            DELETE
            FROM items
            WHERE id = ? 
        ");

        $stmt->bind_param("i", $item_id);

        if ($stmt->execute()) {
            $success = "Item deleted successfully.";
        } else {
            $error = "There was a problem removing this item.";
        }

        $stmt->close();
    
}

$conn->close();
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
        <h2>Confirm Deletion</h2>

        <?php if ($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green; text-align:center;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">

            

            <label for=""> Item Name: <?php echo $item['item_name']; ?> </label>

            <label for=""> Category: <?php echo $item['category']; ?> </label>
            

            <label for=""> Details: <?php echo $item['details']; ?></label>

            <label for=""> value: £ <?php echo $item['value']; ?></label>
            

            <input type="submit" name="Confirm" value="Confirm Delete">

        </form>

        <hr>

        <p><a class="back_button" href="user_item.php">Return to My Items</a></p>
    </section>
</main>
<?php include './includes/footer.php'; ?>