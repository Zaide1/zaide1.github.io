<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://localhost/zaide1.github.io-main/assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/payment.css">
    <title>Clothing Store</title>
</head>
<body>
    <?php require("nav.php") ?>
    <div class="container2">
        <div class="cart-section">
            <h2>Your Shopping Cart</h2>


            <!-- Display cart contents -->
            <?php
                session_start();
                $order_total = 0;
                

                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $image_directory = 'assets/img/' . $item['product_name'] . '.webp'; // images are in webp format
                        $default_image = 'assets/img/outer.png'; // Default image path if product image not found
                        $image_path = file_exists($image_directory) ? $image_directory : $default_image; // Set image source based on existence

                        $item_total_price = $item['default_price'] * $item['quantity'];
                        $order_total += $item_total_price;



                        echo '<div class="cart-item" id="cart-item-' . $key . '">';
                        echo '<img src="' . $image_path . '" alt="' . $item['product_name'] . '" width="100px" height="100px">';
                        echo '<p>Product: ' . $item['product_name'] . ' | Price: £' . $item['default_price'] . ' | Quantity: ' . $item['quantity'] . ' | Size: ' . $item['size_id'] .'</p>';
                        echo '<button class="remove-btn" onclick="removeItem(' . $key . ')">Remove</button>';
                        echo '</div>';


                    }
                } else {
                    echo '<p>Your cart is empty</p>';
                }

                echo '<h3> Order Total: ' . $order_total . '</h3>';
            ?>

            <?php
            
            if (!isset($_SESSION['user_id'])) {


                // Redirect to the login page
                header("Location: login.html");
                exit();
            }

            ?>

            <!-- Payment form -->
            <div class="container">
                <h2>Payment Details</h2>
                <form method="post" action="backend/process_order.php">
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="Enter card number" required>
                    </div>
                    <div class="form-group">
                        <label for="sort-code">Sort Code</label>
                        <input type="text" id="sort-code" name="sort-code" placeholder="Enter card number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="default_payment" name="default_payment">
                        <label class="inline" for="default_payment">Default Payment</label>
                    </div>
                    <button type="submit">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
