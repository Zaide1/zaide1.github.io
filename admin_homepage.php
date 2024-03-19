<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Alyx Admin</title>
    </head>
    <body>
        <div class="container mt-4">
            <h2>Admin Dashboard</h2>
            <a href="admin_add_product.php" class="btn btn-primary">Add new product</a>
            <a href="backend/current_products.php" class="btn btn-secondary">Current products</a>
        	<a href="index.php" class="Return to Homepage">Return to Homepage</a>
        </div>
        <?php
try {
    require_once('backend/connect_database.php');

    // Fetch all products and their variants
    $products_query = $db->prepare("SELECT * FROM product");
    $products_query->execute();
    $products = $products_query->fetchAll(PDO::FETCH_ASSOC);

    // Iterate through each product
    foreach ($products as $product) {
        echo "<div class='product'>";
        echo "<h3>{$product['product_name']}</h3>";

        // Fetch variants for the current product
        $variants_query = $db->prepare("SELECT pe.* , s.size_name FROM product_entry pe INNER JOIN sizes s ON pe.size_id = s.size_id WHERE pe.product_id = :product_id");
        $variants_query->bindParam(':product_id', $product['product_id']);
        $variants_query->execute();
        $variants = $variants_query->fetchAll(PDO::FETCH_ASSOC);

        // Iterate through each variant
        $lowStock = false; // Flag to track if any variant has low stock
        foreach ($variants as $variant) {
            if ($variant['stock'] < 5) { // Check if stock level is below threshold
                $lowStock = true;
                break; // No need to check further if any variant has low stock
            }
        }

        // Display warning box if any variant has low stock
        if ($lowStock) {
            echo "<div class='warning-box'>Low stock or out of stock</div>";
        }

        // Display variants with their stock levels
        echo "<ul>";
        foreach ($variants as $variant) {
            $stockLevel = $variant['stock'];
            $sizeName = $variant['size_name'];
            $stockStatus = $stockLevel <= 0 ? "Out of stock" : ($stockLevel < 5 ? "Low stock" : "In stock");
            $stockColor = $stockLevel <= 0 ? "red" : ($stockLevel < 5 ? "orange" : "green");

            echo "<li style='color: $stockColor;'>$sizeName - $stockStatus</li>";
        }
        echo "</ul>";

        echo "</div>"; // Close product div
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>