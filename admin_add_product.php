<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Alyx Admin</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    require_once('backend/connect_database.php');

    // Fetch categories from the database
    $query = "SELECT category_id, category_name FROM category"; // Modify the query as per your table structure
    $stmt = $db->query($query);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container mt-4">
        <form action="backend/add_product.php" method="post">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" name="product_name" id="prod_name">
            </div>

            <div class="form-group">
                <label for="categories">category:</label>
                <select class="form-control" name="category" id="category_select">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['category_id']; ?>">
                            <?php echo $category['category_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <!-- <label for="product_image">Product Image:</label>
                <input type="file" class="form-control" name="product_image"> -->
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description">
            </div>

            <div class="form-group">
                <label for="colours">Colours (comma-separated):</label>
                <input type="text" class="form-control" name="colours" id="colors" value="">
            </div>

            <div class="form-group" id="sizeInputs">
                <?php
                    $size_query = "SELECT size_id, size_name FROM sizes";
                    $stmt_size = $db->query($size_query);
                    $sizes = $stmt_size->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($sizes as $size) {
                        echo '<input type="checkbox" name="selected_sizes[]" value="' . $size['size_id'] . '"> ' . $size['size_name'] . '<br>';
                    }
                ?>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    
</body>
</html>