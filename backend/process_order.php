<?php
session_start();
require_once('connect_database.php');

// Check if user is logged in 
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.html");
    exit;
}

// Retrieve session data
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO orders (order_id, user_id,order_date,order_status,payment_id,order_address_id,order_total) VALUES (?, ?, ?, ?, ?, ?)");

$user_id = $_SESSION['user_id']; // Assuming you have a user_id stored in the session
$stmt->bind_param("ississ", $user_id, $product_name, $price, $card_number, $expiry_date, $cvv);

// Set parameters and execute
foreach ($cart as $item) {
    $product_name = $item['product_name'];
    $price = $item['default_price'];
    $card_number = $_POST['card_number']; // Assuming you have sanitized user input
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    $stmt->execute();
}

// Close statement and connection
$stmt->close();
$conn->close();

// Clear the cart after the order has been processed
unset($_SESSION['cart']);

// Redirect to a thank you page or display a success message
header("Location: thank_you.php");
exit;
?>