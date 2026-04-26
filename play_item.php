<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?? 'myWebsite' ?></title>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <link rel="stylesheet" href="./css/style_play.css">
</head>
<body>

<?php
session_start();
$page_title = 'play';

    $host = getenv('DB_HOST');
$port = intval(getenv('DB_PORT'));
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

$conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$item_id = $_GET['id'];
echo "<script>console.log(" . $item_id . ");</script>";

$sql = "SELECT item_name, `image`, audio
        FROM items
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

while($item = $result->fetch_assoc()){
    $item_name = $item['item_name'];
    echo "<script>console.log(" . $item_name . ");</script>";
    $item_cover = $item['image'];
    echo "<script>console.log(" . $item_cover . ");</script>";
    $item_audio = $item['audio'];
    echo "<script>console.log(" . $item_audio . ");</script>";
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
        <input type="hidden" name="page" value="landing_page">
      </form>
    </div>
    <!-- what is the next comminet about -->
    <!-- hereo for cat -->
    <!-- login button -->
    <div>
      <a class='log_button' href='user_login.php'>Login</a>
    </div>
  </div>
  <br>
    br>
  <section class+="customer-form">
    <div class="player paused">
    <div class="album">
      <div class="cover">
        <!-- need to have the album cover image puled from the database -->
        <div><img src="<?php echo $item_cover; ?>" alt="<?php echo $item_name; ?>" /></div>
      </div>
    </div>
    
    <div class="info">
      <div class="time">
        <span class="current-time">0:00</span>
        <span class="progress"><span></span></span>
        <span class="duration">0:00</span>
      </div>
      
      <!-- item name to be pulled from the database -->
      <h1><?php echo $item_name; ?></h1>
      
    </div>
    
    <div class="actions">
      
      <button class="button rw">
        <div class="arrow"></div>
        <div class="arrow"></div>
      </button>
      <button class="button play-pause">
        <div class="arrow"></div>
      </button>
      <button class="button ff">
        <div class="arrow"></div>
        <div class="arrow"></div>
      </button>
      <button class="repeat"></button>
    </div>
    
    <!-- audio to be pulled from the database -->
    <audio preload src="<?php echo $item_audio; ?>"></audio>
    <script src="js/play.js"></script>
  </div>
  <br>


  <a class="back_button" href="landing_page.php" >Landing Page</a>

  </section>
</main>

<?php include './includes/footer.php'; ?> 