<?php session_start();?>
<?php include 'includes/header.php'; ?>

<?php
session_start();
echo "<script>console.log('Reached point load');</script>";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>console.log('Reached point 5');</script>";

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        $error = "Both fields are required.";
        echo "<script>console.log('Reached point 4');</script>";
    }
    else{

        $host = getenv('MYSQLHOST');
        $port = getenv('MYSQLPORT');
        $user = getenv('MYSQLUSER');
        $pass = getenv('MYSQLPASSWORD');
        $db   = getenv('MYSQLDATABASE');

        $conn = new mysqli($host, $user, $pass, $db, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows === 1){
            $row = $result->fetch_assoc();
            $storedHash = $row['password'];
            echo "<script>console.log('Reached point 2');</script>";

            if(password_verify($password, $storedHash)){
                $_SESSION['user_id']=$row['id'];
                $_SESSION['username']=$username;
                echo "<script>console.log('Reached point 1');</script>";


                header("Location: admin_home.php");
                exit();
            }
            else{
                $error = "Invalid password.";
            }
        }
        else{
            $error = "No user found with that username.";
        }
        $stmt->close();
        $conn->close();
    }
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
        <h2>Admin Login</h2>

        
        <?php if($error): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="post" >
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <button type="submit">Login</button>
            </form>
            <br>
            <a class="log_button" href="user_register.php">register a new user</a>
            <br>
            <a class="log_button" href="user_login.php">user login</a>
            <br>
            <a class="back_button" href="landing_page.php" >Landing Page</a>
    </section>
</main>

<?php include 'includes/footer.php'; ?>