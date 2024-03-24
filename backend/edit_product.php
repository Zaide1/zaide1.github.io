<?php
// Include database connection
require_once('connect_database.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product ID from form submission
    $product_id = $_POST['product_id'];

    // Here you should retrieve the other form fields for editing the product details
    // For demonstration, let's assume we're updating the product name only
    $new_product_name = $_POST['new_product_name']; // Modify this as per your form field name

    // Update the product name in the database
    try {
        $update_query = "UPDATE product SET product_name = :product_name WHERE product_id = :product_id";
        $stmt = $db->prepare($update_query);
        $stmt->bindParam(':product_name', $new_product_name);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        // Redirect back to the admin dashboard or any other desired page after successful update
        header("Location: ../admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the form is not submitted via POST method, redirect to the edit product page
    header("Location: ../admin_edit_product.php");
    exit();
}
?>
