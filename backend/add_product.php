<?php
    require_once('connect_database.php');
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $selected_sizes = $_POST['selected_sizes'];
    $colour_input = $_POST['colours'];
    $colours_array = explode(',', $colour_input);
    $price = $_POST['price'];
    $stock = $_POST['stock_levels'];


    try{
        $stat = $db ->prepare("INSERT INTO product VALUES (default,?,?,?,?)");
        $stat ->execute(array($product_name,$category,$description,$price));
        $product_id = $db->lastInsertId();

        foreach ($colours_array as $colour) {
            // Check if the selected color exists in the colour table
            $check_colour_query = "SELECT colour_id FROM colour WHERE colour_name = ?";
            $stmt_check_colour = $db->prepare($check_colour_query);
            $stmt_check_colour->execute([$colour]);
            $colour_row = $stmt_check_colour->fetch(PDO::FETCH_ASSOC);
        
            if (!$colour_row) {
                // If the colour doesn't exist, insert it into the colour table
                $insert_colour_query = "INSERT INTO colour VALUES (default, ?)";
                $stmt_insert_colour = $db->prepare($insert_colour_query);
                $stmt_insert_colour->execute([$colour]);
        
                // Get the newly inserted colour's ID
                $colour_id = $db->lastInsertId();
            } else {
                // If the colour already exists, use its ID
                $colour_id = $colour_row['colour_id'];
            }

            
            // Debugging - Output colour IDs and names for verification
            echo "Colour: $colour, Colour ID: $colour_id<br>";
        
            // Process sizes separately for each color
            foreach ($selected_sizes as $size_id) {
                // Insert into product_entry using the obtained colour_id and size
                $insert_variant_query = "INSERT INTO product_entry VALUES (DEFAULT, ?, ?, ?, ?, ?)";
                $stmt_variant = $db->prepare($insert_variant_query);
                $stmt_variant->execute([$product_id, $size_id, $colour_id, $price,$stock[$size_id]]);
            }
        }
        header('Location: ../index.php');
        exit();

    } 
    catch(PDOException $ex){
        echo "Sorry a database error occured";
        echo "Your details are <em>". $ex->getMessage()."</em>";
        echo "<p> " . $stock[1] . "</p>";
    }
 
?>