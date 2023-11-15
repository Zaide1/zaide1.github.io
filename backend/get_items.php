<?php
require_once('database.php');

// Query the database to retrieve items
$items = []; // Initialize an array to store the items
$query = $db->query("SELECT product_name FROM product");
if ($query) {
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row; // Store each item in the array
    }
}

// Include the HTML template
include('../items_template.html');
?>

<?php foreach ($items as $item) : ?>
    <li><?php echo $item['product_name']; ?></li>
<?php endforeach; ?>

