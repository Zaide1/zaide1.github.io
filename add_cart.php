<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        // Retrieve product details and add to cart
        try {
            require_once('backend/connect_database.php');

            $product_id = htmlspecialchars($_POST['product_id']);
            $size_id = htmlspecialchars($_POST['size']);
            $quantity = htmlspecialchars($_POST['quantity']);
            $stat = $db->prepare("SELECT product_name, default_price FROM product WHERE product_id = :id;");
            $stat->bindParam(':id', $product_id);
            $stat->execute();

            if ($stat->rowCount() > 0) {
                $product = $stat->fetch();

                // Add the product to the cart session variable
                $cart_item = array(
                    'product_id' => $product_id,
                    'product_name' => $product['product_name'],
                    'default_price' => $product['default_price'],
                    'size_id' => $size_id,
                    'quantity' => $quantity
                    // Add more details as needed
                );

                // Initialize the cart session variable if not already set
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                // Add the cart item to the session
                $_SESSION['cart'][] = $cart_item;
            } else {
                echo 'Item not found';
            }

            // Redirect back to the referring page
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Invalid request';
    }
} else {
    echo 'Invalid request method';
}
?>
