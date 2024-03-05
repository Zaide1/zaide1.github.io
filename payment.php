<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clothing Store</title>
</head>
<body>
    <nav class="navbar">
        <!-- Navbar content -->
    </nav>

    <div class="container2">
        <div class="cart-section">
            <h2>Your Shopping Cart</h2>

            <!-- Display cart contents -->
            <?php
            session_start();
            
            if (!isset($_SESSION['user_id'])) {


                // Redirect to the login page
                header("Location: login.html");
                exit();
            }

            ?>

            <!-- Payment form -->
            <form method="post" action="backend/process_order.php">
                <h2>Payment Details</h2>
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required><br><br>

                <label for="expiry_date">Expiry Date:</label>
                <input type="text" id="expiry_date" name="expiry_date" required><br><br>

                <label for="sort-code">Sort Code:</label>
                <input type="text" id="sort-code" name="sort-code" required><br><br>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required><br><br>

                <label for="default_payment">Default Payment:</label>
                <input type="checkbox" id="default_payment" name="default_payment">

                <input type="submit" value="Pay Now">
            </form>
        </div>
    </div>
</body>
</html>
