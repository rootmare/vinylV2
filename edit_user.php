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
    SELECT username, password, email
    FROM users
    WHERE id = ? 
");
$stmt->bind_param("i", $item_id, );
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

    $item_name = trim($_POST['username']);
    $category  = trim($_POST['password']);
    $details   = trim($_POST['email']);
    

    if (empty($item_name) || empty($category)) {
        $error = "Item name and category are required.";
    } else {
        $hashedPassword = password_hash($category, PASSWORD_DEFAULT);
        // Update item
        $stmt = $conn->prepare("
            UPDATE users
            SET username = ?, password = ?, email = ?
            WHERE id = ? 
        ");

        $stmt->bind_param("sssi", $item_name, $hashedPassword, $details, $item_id);

        if ($stmt->execute()) {
            $success = "Item updated successfully.";
        } else {
            $error = "There was a problem updating this item.";
        }

        $stmt->close();
    }
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
        <h2>Edit Item</h2>

        <?php if ($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green; text-align:center;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">

            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($item['username']); ?>" required>

            <label>Password:</label>
            <input type="text" name="password" value="<?php echo htmlspecialchars($item['password']); ?>" required>

            <label>Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($item['email']); ?>" required>


            <button type="submit">Update user</button>

        </form>

        <hr>

        <p><a class="back_button" href="admin_users.php">Return to users</a></p>
    </section>
</main>
<?php include './includes/footer.php'; ?>