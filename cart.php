<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Lato:wght@300&family=Roboto:wght@100;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">

    <title>Clothing Store</title>

</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="mens.php">Mens</a>
            <a href="womens.php">Womens</a>
            <a href="cart.php" class="active">Basket</a>
            <a href="myaccount.php">My Account</a>
            <a href="login.html">Login</a>
            <a href="contact.html">Contact</a>
        </div>
    </nav>

    <!-- Display cart contents inside container2 -->
<div class="container2">
    <div class="cart-section">
        <h2>Your Shopping Cart</h2>

        <?php
session_start();

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $key => $item) {
        $image_directory = 'assets/img/' . $item['product_name'] . '.webp'; // images are in webp format
        $default_image = 'assets/img/outer.png'; // Default image path if product image not found
        $image_path = file_exists($image_directory) ? $image_directory : $default_image; // Set image source based on existence

        echo '<div class="cart-item" id="cart-item-' . $key . '">';
        echo '<img src="' . $image_path . '" alt="' . $item['product_name'] . '" width="100px" height="100px">';
        echo '<p>Product: ' . $item['product_name'] . ' | Price: £' . $item['default_price'] . '</p>';
        echo '<button class="remove-btn" onclick="removeItem(' . $key . ')">Remove</button>';
        echo '</div>';
    }
    echo '<a href="address.php"><button>Buy Now</button></a>';
} else {
    echo '<p>Your cart is empty</p>';
}
?>

    </a>
    </div>
</div>

<script>
    function removeItem(key) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var itemToRemove = document.getElementById('cart-item-' + key);
                if (itemToRemove) {
                    itemToRemove.remove();
                }
            }
        };
        xhr.send('key=' + key);
    }
</script>

</body>
</html>