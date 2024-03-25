<?php
// Include database connection
require_once('connect_database.php');

// Retrieve form data
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$category = $_POST['category'];
$description = $_POST['description'];
$selected_sizes = $_POST['selected_sizes'];
$colour_input = $_POST['colours'];
$colours_array = explode(',', $colour_input);
$price = $_POST['price'];
$stock = $_POST['stock_levels'];

echo $colour_input;

try {
    // Update product details
    $update_product_query = "UPDATE product SET product_name = ?, category_id = ?, description = ?, default_price = ? WHERE product_id = ?";
    $stmt_update_product = $db->prepare($update_product_query);
    $stmt_update_product->execute([$product_name, $category, $description, $price, $product_id]);

    // Retrieve existing product entries for the product
    $select_existing_variants_query = "SELECT size_id, colour_id FROM product_entry WHERE product_id = ?";
    $stmt_select_existing_variants = $db->prepare($select_existing_variants_query);
    $stmt_select_existing_variants->execute([$product_id]);
    $existing_variants = $stmt_select_existing_variants->fetchAll(PDO::FETCH_ASSOC);

    // Update product variants
    foreach ($colours_array as $colour) {
        // Check if the selected color exists in the colour table
        $check_colour_query = "SELECT colour_id FROM colour WHERE colour_name = ?";
        $stmt_check_colour = $db->prepare($check_colour_query);
        $stmt_check_colour->execute([$colour]);
        $colour_row = $stmt_check_colour->fetch(PDO::FETCH_ASSOC);
    
        if (!$colour_row) {
            // If the colour doesn't exist, insert it into the colour table
            $insert_colour_query = "INSERT INTO colour VALUES (DEFAULT, ?)";
            $stmt_insert_colour = $db->prepare($insert_colour_query);
            $stmt_insert_colour->execute([$colour]);
    
            // Get the newly inserted colour's ID
            $colour_id = $db->lastInsertId();

        } else {
            // If the colour already exists, use its ID
            $colour_id = $colour_row['colour_id'];
        }
    

        // Updates colour id to the newly selected one.
        $update_colour_query = "UPDATE product_entry SET colour_id = ? WHERE product_id = ?";
        $stmt_update_colour = $db->prepare($update_colour_query);
        $stmt_update_colour->execute([$colour_id, $product_id]);
    
        // Process sizes separately for each color
        foreach ($selected_sizes as $size_id) {
            // Check if the product entry already exists for this size and colour
            $check_entry_query = "SELECT * FROM product_entry WHERE product_id = ? AND size_id = ? AND colour_id = ?";
            $stmt_check_entry = $db->prepare($check_entry_query);
            $stmt_check_entry->execute([$product_id, $size_id, $colour_id]);
            $existing_entry = $stmt_check_entry->fetch(PDO::FETCH_ASSOC);
    
            if ($existing_entry) {
                // If the entry exists, update its price and stock
                $update_entry_query = "UPDATE product_entry SET price = ?, stock = ? WHERE product_id = ? AND size_id = ? AND colour_id = ?";
                $stmt_update_entry = $db->prepare($update_entry_query);
                $stmt_update_entry->execute([$price, $stock[$size_id], $product_id, $size_id, $colour_id]);
            } else {
                // If the entry doesn't exist, insert it
                $insert_variant_query = "INSERT INTO product_entry VALUES (DEFAULT, ?, ?, ?, ?, ?)";
                $stmt_variant = $db->prepare($insert_variant_query);
                $stmt_variant->execute([$product_id, $size_id, $colour_id, $price, $stock[$size_id]]);
            }
        }
    }
    // Redirect to admin page after successful update
    header('Location: ../admin_homepage.php');
    exit();
} catch (PDOException $ex) {
    // Handle database error
    echo "Sorry, a database error occurred.<br>";
    echo "Details: " . $ex->getMessage();
}
?>