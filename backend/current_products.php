<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyx</title>
</head>
<body>
    <?php
    session_start();
    require_once('connect_database.php');

    $item_sql = $db->prepare("
    SELECT pe.variant_id, p.product_name, s.size_name
    FROM product_entry pe
    INNER JOIN product p ON pe.product_id = p.product_id
    INNER JOIN sizes s ON pe.size_id = s.size_id
");
    $item_sql->execute();

    if ($item_sql->rowCount() > 0) {

        echo '<table class="table">';
        echo '<thead class="thead-light">';
        echo '<tr>';
        echo '<th scope="col">Item</th>';
        echo '<th scope="col">Size</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $item_sql->fetch()) {
    		echo '<tr>';
    		echo '<td><a href="editproduct.php?id=' . htmlspecialchars($row['variant_id'], ENT_QUOTES) . '">' . htmlspecialchars($row['product_name'], ENT_QUOTES) . '</a></td>';
    		echo '<td>' . htmlspecialchars($row['size_name'], ENT_QUOTES) . '</td>';
    		echo '</tr>';
		}

        echo '</tbody>';
        // End the HTML table
        echo '</table>';
      } else {
          // Display a message if no results were returned
          echo ('No items found.');
      }
    ?>
</body>
</html>