<?php
$servername = "localhost";
$username = "u-220096670";
$password = "TMvfrRhGj9MR8Ut";
$dbname = "u_220096670_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request when the add to cart button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the POST request
    $variant_id = $_POST["variant_id"];
    $quantity = $_POST["quantity"];

    // Calculate the total price
    $total_price = 0;

    // Assuming you have a product_entry table to get the price
    $sql_price = "SELECT price FROM product_entry WHERE variant_id = $variant_id";
    $result_price = $conn->query($sql_price);

    if ($result_price->num_rows > 0) {
        $row_price = $result_price->fetch_assoc();
        $total_price = $row_price["price"] * $quantity;
    }

    // Insert data into the cart table
    $sql_insert = "INSERT INTO cart (user_id, product_variant_id, quantity, added_at) VALUES (1, $variant_id, $quantity, CURRENT_TIMESTAMP)";
    $conn->query($sql_insert);

    // Redirect to the cart page or any other page you want
    header("Location: cart_page.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
</head>

<body>

    <!-- Your HTML form goes here -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="variant_id">Variant ID:</label>
        <input type="text" name="variant_id" required>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" required>
        <br>
        <button type="submit">Add to Cart</button>
    </form>

</body>

</html>