<?php 
session_start();

// determine requested page or default to  the login page
$page= $_GET['page'] ?? 'user_login';

// inclluse sharec page layout 
include 'includes/header.php';

echo "<main>";
echo "<section class='customer-form'>";
 
// routing table
switch ($page) {
    case 'user_login':
        include 'user_login.php';
        break;
    case 'user_register':
        include 'user_register.php';
        break;
    case 'user_home':
        include 'user_home.php';
        break;
    case 'submit_item':
        include 'submit_item.php';
        break;
    case 'user_itms':
        include 'user_items.php';
        break;
    case 'user_edit_item':
        include 'user_edit_item.php';
        break;
    case 'logout':
        include 'logout.php';
        break;
    default:
        echo "<p>Page not found.</p>";
        break;
}

echo "</section>";
echo "</main>";

include 'includes/footer.php';
?>
