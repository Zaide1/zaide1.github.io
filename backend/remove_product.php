<?php
    require_once('connect_database.php');

    // Check if product_id is provided via POST
    if(isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        try {
            // Begin a transaction
            $db->beginTransaction();

            // Delete related entries from product_entry table
            $delete_product_entry_query = "DELETE FROM product_entry WHERE product_id = ?";
            $stmt_delete_product_entry = $db->prepare($delete_product_entry_query);
            $stmt_delete_product_entry->execute([$product_id]);

            // After deleting related entries, delete the product itself from product table
            $delete_product_query = "DELETE FROM product WHERE product_id = ?";
            $stmt_delete_product = $db->prepare($delete_product_query);
            $stmt_delete_product->execute([$product_id]);

            // Commit the transaction if all queries are successful
            $db->commit();

            // Redirect to admin dashboard or any other desired page
            header('Location: ../admin_dashboard.php');
            exit();
        } catch(PDOException $ex) {
            // Rollback the transaction if any query fails
            $db->rollBack();

            // Handle database errors
            echo "Sorry, a database error occurred: " . $ex->getMessage();
        }
    } else {
        // Handle case where product_id is not provided
        echo "Product ID is missing or invalid.";
    }
?>
