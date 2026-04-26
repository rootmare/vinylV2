<?php session_start();?>
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

// Get search inputs
$item_name = $_GET['item_name'] ?? '';
$category  = $_GET['category'] ?? '';
$details   = $_GET['details'] ?? '';
$page = $_GET['page'] ?? '';

// Base query
$sql = "SELECT * FROM items WHERE 1=1";
$params = [];
$types = "";

// Add filters if provided
if (!empty($item_name)) {
    $sql .= " AND item_name LIKE ?";
    $params[] = "%" . $item_name . "%";
    $types .= "s";
}

if (!empty($category)) {
    $sql .= " AND category LIKE ?";
    $params[] = "%" . $category . "%";
    $types .= "s";
}

if (!empty($details)) {
    $sql .= " AND details LIKE ?";
    $params[] = "%" . $details . "%";
    $types .= "s";
}

// Prepare query
$stmt = $conn->prepare($sql);

// Bind params if present
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
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
        <h2>Search Results</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                echo "<p>";
                echo "<strong>" . htmlspecialchars($row['item_name']) . "</strong><br>";
                echo "Category: " . htmlspecialchars($row['category']) . "<br>";
                echo'<br>';
                echo "<a class='dashboard_button' href='item_details.php?id=" . $row['id'] . "'>View Details</a>";
                echo "</p><hr>";

            }
        } else {
            echo "<p>No results found for your search.</p>";
        }

        echo "<p><a class='back_button' href='" . htmlspecialchars($page) . ".php'>Back to " . ucfirst(htmlspecialchars($page)) . "</a></p>";
        $stmt->close();
        $conn->close();
        ?>
    </section>
</main>

<?php include './includes/footer.php'; ?>