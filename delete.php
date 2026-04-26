<?php session_start();?>
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

    if(isset($_POST['Confirm'])){
        $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
        $stmt->bind_param(
            "i",
            $_POST['id']
        );
        
        $stmt->execute();
        $stmt->close();

        header("Location: veiw.php");
        exit();
    }

    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
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
        <h2>Delete Customer</h2>

        <form method ="post" >
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for=""> First Name: <?php echo $row['first_name']; ?> </label>

            <label for=""> Last Name: <?php echo $row['last_name']; ?> </label>
            

            <label for=""> Email: <?php echo $row['email']; ?></label>
            

            <input type="submit" name="Confirm" value="Confirm Delete">
        </form>
    </section>
</main>

<?php include './includes/footer.php';?>