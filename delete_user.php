<?php session_start();?>
<?php include './includes/header.php'; ?>
<?php
session_start();

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

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
$item_id = $_GET['id'];
$error = "";
$success = "";

// Fetch item to edit
$stmt = $conn->prepare("
    SELECT username, password, email
    FROM users
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

    

    
        // deletes user
        $stmt = $conn->prepare("
            DELETE
            FROM users
            WHERE id = ? 
        ");

        $stmt->bind_param("i", $item_id);

        if ($stmt->execute()) {
            $success = "Item deleted successfully.";
        } else {
            $error = "There was a problem removing this item.";
        }

        $stmt->close();
    // deletes user's items

    $stmt = $conn->prepare("
        DELETE
        FROM items
        WHERE created_by = ? 
    ");

    $stmt->bind_param("i", $item_id);
    $stmt->execute();
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

            

            <label for=""> Username: <?php echo $item['username']; ?> </label>

            <label for=""> Password: <?php echo $item['password']; ?> </label>
            

            <label for=""> Email: <?php echo $item['email']; ?></label>

            

            <input type="submit" name="Confirm" value="Confirm Delete">

        </form>

        <hr>

        <a class="back_button" href="admin_users.php">Return to Users</a>
    </section>
</main>
<?php include './includes/footer.php'; ?>