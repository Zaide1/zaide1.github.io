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

$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$sort_code = $_POST['sort-code'];
$cvv = $_POST['cvv'];
$default_payment = isset($_POST['default_payment']) ? 1 : 0; // Assuming default_payment is a checkbox
$address_id = $_SESSION['address_id'];

$sql = "INSERT INTO payment (payment_id, user_id, account_number, expiry_date, sort_code,is_default) VALUES (DEFAULT,$user_id, '$card_number', '$expiry_date', '$sort_code', '$default_payment')";
$stat = $db ->prepare($sql);
        $stat ->execute();
        $payment_id = $db->lastInsertId();


// Insert into order_items with the order_id
$order_sql = "INSERT INTO `orders` (order_id,user_id,order_date,order_status,payment,order_address_id,order_total) VALUES (DEFAULT,$user_id,DEFAULT,1,'$payment_id', '$address_id', 100)";
$order_stat = $db ->prepare($order_sql);
    $order_stat ->execute();
    $order_id = $db->lastInsertId();

   
$item_stmt = $db ->prepare("INSERT INTO order_items (order_item_id, product_variant_id,quantity,order_id) VALUES (DEFAULT, ?, 1 , ?)");

// Get order items from session cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
// Set parameters and execute
foreach ($cart as $item) {
    $product_id = $item['product_id'];
    $size_id = $item['size_id'];

    // Query to fetch product_variant_id based on product_id and size_id
    $variant_query = $db->prepare("SELECT variant_id FROM product_entry WHERE product_id = ? AND size_id = ?");
    $variant_query->execute([$product_id, $size_id]);
    $variant_result = $variant_query->fetch();

    // If product_variant_id is found, insert into order_items table
    if ($variant_result) {
        $product_variant_id = $variant_result['variant_id'];
        $item_stmt->execute([$product_variant_id, $order_id]);
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