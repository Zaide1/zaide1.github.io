<?php
session_start();
require_once('backend/connect_database.php');

// Check if the user is logged in
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Assuming 'login.html' is your login page
    header('Location: login.html');
    exit;
}


if (isset($_POST['product_id'], $_POST['comment'], $_POST['rating'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    $comment = htmlspecialchars($_POST['comment']);
    $rating = htmlspecialchars($_POST['rating']);
    $user_id = $_SESSION['user_id']; // Directly use the user_id from the session

    // No need to fetch the user_id again from the database

    // Insert the review into the database
    $query = $db->prepare("INSERT INTO reviews (user_id, product_id, rating, comments) VALUES (:user_id, :product_id, :rating, :comments)");
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':product_id', $product_id);
    $query->bindParam(':rating', $rating);
    $query->bindParam(':comments', $comment);

    if ($query->execute()) {
        header("Location: items_buy.php?id=" . $product_id); // Redirect back to the item page
    } else {
        echo "There was an error posting your comment. Please try again.";
    }
} else {
    echo "Invalid request.";
}

