<?php
session_start();
include 'includes/header.php';

// make sure ther is a urser logged in
if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

$error = '';
$success = '';

//handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $details = trim($_POST['details']);
    $value = trim($_POST['value']);
    $image = trim($_POST['image']);
    $audio = trim($_POST['audio']);

    // basic validation
    if($item_name == "" || $category == ""){
        $error = "Item name and category are required.";
    }
    else{
        // database connection
        $conn = new mysqli("localhost", "root", "", "customer_db");

        if( $conn->connect_error){
        die("database connection failed: ". $conn->connect_error);
    }

    // Insert item
    $stmt = $conn->prepare(" 
    INSERT INTO items 
    (item_name, category, details, value, created_by,  image, audio)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssiss",
        $item_name,
        $category,
        $details,
        $value,
        $_SESSION['user_id'],
        $image,
        $audio
    );

    if($stmt->execute()){
        $success = "Item submission has been saved sucessfully.";
    }
    else{
        $error = "Database error: ". $stmt->error;
    }

    $stmt->close();
    $conn->close();
    };
}
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
        <h2>Submit a new Item</h2>
        

        <?php if($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if($success): ?>
            <p style="color:green; text-align:center;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method = "post">
            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>
            <br><br>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>
            <br><br>

            <label for="details">Details:</label>
            <textarea id="details" name="details"></textarea>
            <br><br>

            <label for="value">Value:</label>
            <input type="number" step="0.01" id="value" name="value">
            <br><br>

            <label for="image">Image link:</label>
            <input type="text" name="image">
            <br><br>

            <label for="audio">Audio link:</label>
            <input type="text" name="audio">
            <br><br>

            <button type="submit">Submit Item</button>
        <form>

        
        <br>
        <br>
        
        
        <a href="user_home.php" class="back_button">Return to Home</a>
    </section>
    
</main>

<?php include 'includes/footer.php'; ?>