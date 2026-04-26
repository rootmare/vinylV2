<?php include './includes/header.php'; ?>
<?php
session_start();

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "customer_db");

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

    $item_name = trim($_POST['item_name']);
    $category  = trim($_POST['category']);
    $details   = trim($_POST['details']);
    $value     = trim($_POST['value']);

    if (empty($item_name) || empty($category)) {
        $error = "Item name and category are required.";
    } else {
        // Update item
        $stmt = $conn->prepare("
            UPDATE items
            SET item_name = ?, category = ?, details = ?, value = ?
            WHERE id = ? 
        ");

        $stmt->bind_param("ssssi", $item_name, $category, $details, $value, $item_id);

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

            <label>Item Name</label>
            <input type="text" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>

            <label>Category</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($item['category']); ?>" required>

            <label>Details</label>
            <input type="text" name="details" value="<?php echo htmlspecialchars($item['details']); ?>">

            <label>Value</label>
            <input type="text" name="value" value="<?php echo htmlspecialchars($item['value']); ?>">

            <button type="submit">Update Item</button>

        </form>

        <hr>

        <p><a class="back_button" href="user_item.php">Return to My Items</a></p>
    </section>
</main>
<?php include './includes/footer.php'; ?>