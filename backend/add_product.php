<?php
    require_once('connect_database.php');
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $query = "INSERT INTO Product (product_name, category, description) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_name, $category, $description]);

    // Retrieve the product_id of the inserted record
    $product_id = $pdo->lastInsertId();

    






?>