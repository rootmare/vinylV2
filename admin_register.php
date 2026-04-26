<?php include 'includes/header.php'; ?>

<?php

$conn = new mysqli("localhost", "root", "", "customer_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        $error = "all feilds are required.";
    }
    else{
        $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $error = "username or email already exists.";
        }
        else{
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            
            $stmt->bind_param("ss", $username, $hashedPassword);

            if($stmt->execute()){
                $success = "Registration successful! You can now log in.";
            }
            else{
                $error = "There was an error creating your account.";
            }

        }

        $stmt->close();

    }

    $conn->close();

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
        <h2>Admin Registration</h2>

        <?php if($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if($success): ?>
            <p style="color:green; text-align:center;"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit">Register</button>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>