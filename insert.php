<?php session_start();?>
<?php
// Connect to database
    $host = getenv('DB_HOST');
$port = intval(getenv('DB_PORT'));
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');

$conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Prepare SQL statement with placeholders
$stmt = $conn->prepare("
    INSERT INTO customers 
    (first_name, last_name, email, phone, address, city, county, postcode, notes) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Bind form data to placeholders
// 'ssssssss' indicates all parameters are strings
$stmt->bind_param(
    "sssssssss", 
    $first_name, $last_name, $email, $phone, $address, $city, $county, $postcode, $notes
);

// Get form data from POST request
$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$email      = $_POST['email'];
$phone      = $_POST['phone'];
$address    = $_POST['address'];
$city       = $_POST['city'];
$county     = $_POST['county'];
$postcode   = $_POST['postcode'];
$notes      = $_POST['notes'];

// Execute statement to insert data
if ($stmt->execute()) {
    echo "Customer added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>