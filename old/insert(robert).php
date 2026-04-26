Example (MySQLi Procedural)
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "form";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO customers (first_name, last_name, email, phone, address, city, county, postcode )
VALUES ('".$_POST["first_name"]."', '".$_POST["last_name"]."', '".$_POST["email"]."', '".$_POST["phone"]."', '".$_POST["address"]."', '".$_POST["city"]."', '".$_POST["county"]."', '".$_POST["postcode"]."')";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

