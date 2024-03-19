<?php
session_start();
require_once('connect_database.php');

// Check if user is logged in 
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.html");
    exit;
}
$user_id = $_SESSION['user_id']; // Assuming you have a user_id stored in the session

// Validate and sanitize user input
$card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
$expiry_date = filter_input(INPUT_POST, 'expiry_date', FILTER_SANITIZE_STRING);
$sort_code = filter_input(INPUT_POST, 'sort-code', FILTER_SANITIZE_STRING);
$cvv = filter_input(INPUT_POST, 'cvv', FILTER_SANITIZE_STRING);
$default_payment = isset($_POST['default_payment']) ? 1 : 0; // Assuming default_payment is a checkbox
$address_id = $_SESSION['address_id'];

// Insert payment details
$payment_sql = "INSERT INTO payment (user_id, account_number, expiry_date, sort_code, is_default) VALUES (?, ?, ?, ?, ?)";
$payment_stmt = $db->prepare($payment_sql);
$payment_stmt->execute([$user_id, $card_number, $expiry_date, $sort_code, $default_payment]);
$payment_id = $db->lastInsertId();


// Insert order details
$order_sql = "INSERT INTO `orders` (user_id, order_status, payment, order_address_id, order_total) VALUES (?, ?, ?, ?, ?)";
$order_stmt = $db->prepare($order_sql);
$order_stmt->execute([$user_id, 1, $payment_id, $address_id, 0]); // order_total is a placeholder, adjust it accordingly
$order_id = $db->lastInsertId();
$order_total = 0;

// Insert order items
$item_sql = "INSERT INTO order_items (product_variant_id, quantity, order_id) VALUES (?, ?, ?)";
$item_stmt = $db->prepare($item_sql);
foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $size_id = $item['size_id'];
    $quantity = $item['quantity'];

    // Query to fetch product_variant_id based on product_id and size_id
    $variant_query = $db->prepare("SELECT variant_id FROM product_entry WHERE product_id = ? AND size_id = ?");
    $variant_query->execute([$product_id, $size_id]);
    $variant_result = $variant_query->fetch();

    if ($variant_result) {

        $product_variant_id = $variant_result['variant_id'];


        $item_stmt->execute([$product_variant_id, $quantity, $order_id]);
    } else {
        // Handle case where product_variant_id is not found
        echo "Error: Product variant not found for product_id = $product_id and size_id = $size_id";
    }
}




// Clear the cart after the order has been processed
unset($_SESSION['cart']);

// Redirect to a thank you page or display a success message
header("Location: ../thankyou.html");
exit;
?>