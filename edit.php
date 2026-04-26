<?php include './includes/header.php';?>
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

    if(isset($_POST['update'])){
        $stmt = $conn->prepare("UPDATE customers SET first_name = ?, last_name = ?, email =? WHERE id = ?");
        $stmt->bind_param(
            "sssi",
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            $_POST['id']
        );

        $stmt->execute();
        $stmt->close();

        header("Location: veiw.php");
        exit();
    }

    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT *FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
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
        <h2>Edit Customer</h2>

        <form method ="post" >
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for=""> First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>

            <label for=""> Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>

            <label for=""> Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

            <input type="submit" name="update" value="upate">
        </form>
    </section>
</main>

<?php include './includes/footer.php';?>