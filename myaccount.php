<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Lato:wght@300&family=Roboto:wght@100;500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">

    <title>Clothing Store</title>
  </head>
  <body>
<?php
session_start();
require_once('backend/connect_database.php');

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {


    // Redirect to the login page
    header("Location: login.html");
    exit();
}

$user_sql = "SELECT user.username, user.email FROM user WHERE user.user_id = ?";
$user_stmt = $db->prepare($user_sql);
$user_stmt->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
$user_stmt->execute();
$user_results = $user_stmt->fetchAll(PDO::FETCH_ASSOC);

$order_sql = "SELECT orders.order_id, orders.order_date, orders.order_total, order_items.product_variant_id, order_items.quantity 
          FROM orders
          LEFT JOIN order_items ON orders.order_id = order_items.order_id
          WHERE orders.user_id = ?" ;

$order_stmt = $db->prepare($order_sql);
$order_stmt->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
$order_stmt->execute();
$order_results = $order_stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($user_results);
echo "</pre>";

echo "<pre>";
print_r($order_results);
echo "</pre>";

?>
    <nav class="navbar">
      <div class="logo">
         <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
          <a href="index.php" >Home</a>
          <a href="mens.php">Mens</a>
          <a href="womens.php" >Womens</a>
          <a href="cart.php" >Basket</a>
          <a href="myaccount.php" class="active">My Account</a>
          <a href="login.html" >Login</a>
          <a href="contact.html">Contact</a>
      </div>
  </nav>

  <div class="container2">
  
    <div class="account-info">
      <section class="profile-section">
        <h2>Profile Information</h2>
        <div class="profile-field">
          Username: 
          <?php 
          echo "<p>" . $_SESSION['username'] . "</p>"
          ?>
        </div>
        <div class="profile-field">
          E-mail: 
          <?php
          echo $user_results[0]['email'];
          ?>
        </div>
        <div class="profile-field">
          Phone:
          07470818294
        </div>
      </section>

      <hr>

      <form id="profile-form" style="display: none;">
        <button id="close-profile-form" class="close-button">X</button>
        <h2>Edit Profile</h2>
        <label for="new-username">Username:</label>
        <input type="text" id="new-username" name="new-username" placeholder="Enter your new username">
    
        <label for="new-email">Email:</label>
        <input type="email" id="new-email" name="new-email" placeholder="Enter your new email">
    
        <label for="new-phone">Phone:</label>
        <input type="text" id="new-phone" name="new-phone" placeholder="Enter your new phone number">
    
        <button type="submit">Save Changes</button>
    </form>
    
    <button id="edit-profile-button">Edit Profile</button>
    
    <script>
        document.getElementById('edit-profile-button').addEventListener('click', function() {
            var profileForm = document.getElementById('profile-form');
            profileForm.style.display = (profileForm.style.display === 'none' || profileForm.style.display === '') ? 'block' : 'none';
        });
    
        document.getElementById('close-profile-form').addEventListener('click', function() {
            var profileForm = document.getElementById('profile-form');
            profileForm.style.display = 'none';
        });
    </script>
    
    
    <form id="password-form" style="display: none;">
        <button id="close-password-form" class="close-button">X</button>
        <h2>Change Password</h2>
        <label for="current-password">Current Password:</label>
        <input type="password" id="current-password" name="current-password" placeholder="Enter your current password">
    
        <label for="new-password">New Password:</label>
        <input type="password" id="new-password" name="new-password" placeholder="Enter your new password">
    
        <label for="confirm-password">Confirm New Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your new password">
    
        <button type="submit">Change Password</button>
    </form>
    
    <button id="change-password-button">Change Password</button>
    
    <script>
        document.getElementById('change-password-button').addEventListener('click', function() {
            var passwordForm = document.getElementById('password-form');
            passwordForm.style.display = (passwordForm.style.display === 'none' || passwordForm.style.display === '') ? 'block' : 'none';
        });
    
        document.getElementById('close-password-form').addEventListener('click', function() {
            var passwordForm = document.getElementById('password-form');
            passwordForm.style.display = 'none';
        });
    </script>
      <hr>
      <section class="orders-section">
        <h2>My Orders</h2>
        <ul id="orders-list">
        <?php
          // Initialize variables to keep track of order details
          $current_order_id = null;
          $order_items = [];

          // Function to fetch product name based on product variant ID
          function getProductVariantName($pdo, $product_variant_id) {
            $stmt = $pdo->prepare("SELECT product_id FROM product_entry WHERE variant_id = ?");
            $stmt->execute([$product_variant_id]);
            $product_entry = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product_entry) {
                $stmt = $pdo->prepare("SELECT product_name FROM product WHERE product_id = ?");
                $stmt->execute([$product_entry['product_id']]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                return $product ? $product['product_name'] : "Unknown Product";
            } else {
                return "Unknown Product";
            }
          }

          // Loop through each order result
          foreach ($order_results as $order) {
              // Check if the order ID has changed
              if ($order['order_id'] !== $current_order_id) {
                  // Output the previous order details if it exists
                  if ($current_order_id !== null) {
                      outputOrder($current_order_id, $order_items);
                      // Reset the order items array for the next order
                      $order_items = [];
                      // Add spacing between orders
                      echo "<br>";
                  }
                  // Update the current order ID
                  $current_order_id = $order['order_id'];
              }
              // Add the order item to the order items array
              $order['product_name'] = getProductVariantName($db, $order['product_variant_id']);
              $order_items[] = $order;
          }

          // Output the last order details
          if (!empty($order_items)) {
              outputOrder($current_order_id, $order_items);
          }

          // Function to output order details
          function outputOrder($order_id, $order_items) {
              echo "<li>";
              echo "<span>Order Number - $order_id </span><br>";
              echo "Order items:<br>";
              foreach ($order_items as $item) {
                  echo "Order item " . $item['product_name'] . "  - Quantity -" . $item['quantity'] . ";<br>";
              }
              echo "Order total: " . $order_items[0]['order_total'] . "<br>";
              echo "Order date: " . $order_items[0]['order_date'] . "<br>";
              echo "<div class=\"order-actions\">";
              echo "<button class=\"edit-button\">Edit</button>";
              echo "<button class=\"delete-button\">Delete</button>";
              echo "</div>";
              echo "</li>";
          }
          ?>
        </ul>
      </section>
   
      <hr>
      <div class="logout-button">
        <form action="logout.php">
          <button id="logout-button">Logout</button>
        </form>
        
      </div>
    </div>
  </div>
  
</body>
</html>