<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Alyx Admin - Edit Product</title>
</head>
<body>
    <?php
    require_once('backend/connect_database.php');

    // Fetch products from the database
    $query = "SELECT product_id, product_name FROM product"; // Modify the query as per your table structure
    $stmt = $db->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container mt-4">
        <h2>Edit Product</h2>
        <form action="backend/edit_product.php" method="post">
            <div class="form-group">
                <label for="product_select">Select Product to Edit:</label>
                <select class="form-control" name="product_id" id="product_select">
                    <?php foreach ($products as $product) { ?>
                        <option value="<?php echo $product['product_id']; ?>">
                            <?php echo $product['product_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Add fields here to edit product details -->
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" name="product_name" id="product_name">
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" class="form-control" name="category" id="category">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" name="price" id="price">
            </div>

            <div class="form-group">
                <label for="colours">Colours (comma-separated):</label>
                <input type="text" class="form-control" name="colours" id="colours">
            </div>

            <div class="form-group">
                <label for="selected_sizes">Selected Sizes:</label>
                <?php
                // Fetch sizes from the database
                $size_query = "SELECT size_id, size_name FROM sizes";
                $stmt_size = $db->query($size_query);
                 $sizes = $stmt_size->fetchAll(PDO::FETCH_ASSOC);

                // Loop through each size to create checkboxes
                foreach ($sizes as $size) {
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selected_sizes[]" id="size_<?php echo $size['size_id']; ?>" value="<?php echo $size['size_id']; ?>">
                        <label class="form-check-label" for="size_<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></label>
                    </div>
                    <?php
                }
                ?>    
            </div>

            <button type="submit" class="btn btn-primary">Edit Product</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
