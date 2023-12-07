<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Alyx Admin</title>
</head>
<body>
    <?php
    require_once('backend/connect_database.php');

    // Fetch categories from the database
    $query = "SELECT category_id, category_name FROM category"; // Modify the query as per your table structure
    $stmt = $db->query($query);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form action="backend/add_product.php" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="prod_name">

        <label for="categories">Category:</label>
        <select name="category" id="category_select">
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['category_id']; ?>">
                    <?php echo $category['category_name']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- <label for="product_image">Product Image:</label>
        <input type="file" name="product_image"> -->

        <label for="description">Description:</label>
        <input type="text" name="description">

        
        <label for="colours">Colours (comma-separated):</label>
        <input type="text" name="colours" id="colors" value="">

        <label for="selected_sizes">Sizes:</label>
        <div id="sizeInputs">
            <?php
                $size_query = "SELECT size_id, size_name FROM sizes";
                $stmt_size = $db->query($size_query);
                $sizes = $stmt_size->fetchAll(PDO::FETCH_ASSOC);

                foreach ($sizes as $size) {
                    echo '<input type="checkbox" name="selected_sizes[]" value="' . $size['size_id'] . '"> ' . $size['size_name'] . '<br>';
                }
            ?>
        </div>

        <input type="submit" value="Add Product">
        
    </form>
</body>
</html>