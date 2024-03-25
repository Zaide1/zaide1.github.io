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
    <link rel="stylesheet" href="assets/css/main.css">

    <title>Clothing Store</title>
  </head>
  <body>

  <?php
session_start();


try {
    require_once('backend/connect_database.php');

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // Retrieve the user ID from the session
        echo "User ID is: " . $userId;
        $user_query = $db->prepare("SELECT user_id FROM user WHERE Username = :username");
        
    } else {
      
        // Optionally, redirect the user to the login page
        // header('Location: login.php');
        // exit();
    }

    // Check if the 'id' parameter exists in the URL
    if (isset($_GET['id'])) {
        // Sanitize and retrieve the product ID from the URL
        $product_id = htmlspecialchars($_GET['id']);

        // Fetch product details
        $stat = $db->prepare("SELECT product_name, category_id, description, default_price FROM product WHERE product_id = :id;");
        $stat->bindParam(':id', $product_id);
        $stat->execute();

        if ($stat->rowCount() > 0) {
            $row = $stat->fetch();
        } else {
            echo 'Item not found';
        }

        // Fetch product variants
        $sizes_stmt = $db->prepare('SELECT pe.size_id, s.size_name, pe.stock FROM product_entry pe INNER JOIN sizes s ON pe.size_id = s.size_id WHERE pe.product_id = :id;');
        $sizes_stmt->bindParam(':id', $product_id);
        $sizes_stmt->execute();

        if ($sizes_stmt->rowCount() > 0) {
          $sizes = $sizes_stmt->fetchAll(PDO::FETCH_ASSOC);
          print_r($sizes);
      } else {
          echo 'Sizes not found for this product';
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

    <nav class="navbar">
      <div class="logo">
         <a href="index.html"><img src="/assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
          <a href="index.php" >Home</a>
          <a href="mens.php" class="active">Mens</a>
          <a href="womens.html">Womens</a>
          <a href="cart.php">Basket</a>
          <a href="myaccount.html">My Account</a>
          <a href="login.html" >Login</a>
          <a href="contact.html">Contact</a>
      </div>
  </nav>

<div class="body2">
    <div class="container">
        <div class="imgBx">
        <?php
            $image_directory = 'assets/img/' . $row['product_name'] . '.webp'; // images are in webp format
            $default_image = 'assets/img/outer.png'; // Default image path if product image not found
            $image_path = file_exists($image_directory) ? $image_directory : $default_image; // Set image source based on existence
            ?>
            <img src="<?php echo $image_path; ?>" alt="Item Image" width="400px" height="400px">
            
        </div>    
            <style>
            form {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }
        /* Add more styling as needed */
    </style>
            
        <div class="details">
          <div class="content">
            <h2><?php echo isset($row['product_name']) ? $row['product_name'] : 'Product not found'; ?></h2>
            <p><?php echo isset($row['description']) ? $row['description'] : 'Description not found'; ?></p>
            <h3>Price: £<?php echo isset($row['default_price']) ? $row['default_price'] : 'Product not found'; ?></h3>
            <div class="purchase-options">
                <form method="post" action="add_cart.php" id="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <label for="size">Available sizes:</label>
                    <select name="size" id="size">
                        <?php foreach ($sizes as $size) : 
                            $keyAsString = strval($size['size_id']); 
                            $stock = $size['stock']; //'stock' is the column name for stock level
                        ?>
                            <option value="<?php echo $keyAsString; ?>" data-stock="<?php echo $stock; ?>"><?php echo $size['size_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div id = "stockWarning"></div> <!-- Warning message container -->
                    <label for="quantity">Quantity:</label>
                    <input type="number" step="1" id="quantity" name="quantity" value="1">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
      </div>


                

        </div>
    </div>

    <div class="details">
      <div class="content">
      </div>
      </div>
</div>

<div class="comments-section">
    <h3>Comments</h3>
    <?php
    try {
        $comments_query = $db->prepare("
            SELECT reviews.rating, reviews.comments, user.Username
            FROM reviews
            INNER JOIN user ON reviews.user_id = user.user_id
            WHERE reviews.product_id = :product_id
        ");
        $comments_query->bindParam(':product_id', $product_id);
        $comments_query->execute();

        if ($comments_query->rowCount() > 0) {
            while ($comment_row = $comments_query->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='comment-entry'>";
                echo "<div class='comment-rating'>";
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $comment_row['rating']) {
                        echo "<span class='star filled'>&#9733;</span>"; // Filled star
                    } else {
                        echo "<span class='star'>&#9734;</span>"; // Empty star
                    }
                }
                echo "</div>"; // .comment-rating
                echo "<p class='comment-text'>" . htmlspecialchars($comment_row['comments']) . "</p>";
                echo "<div class='comment-user'>" . htmlspecialchars($comment_row['Username']) . "</div>"; // Display the username
                echo "</div>"; // .comment-entry
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
    } catch (PDOException $e) {
        echo 'Error fetching comments: ' . $e->getMessage();
    }
    ?>
</div>



<div class="comment-form">
    <h3>Leave a comment</h3>
    <form action="post_comment.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating" required>
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
        <textarea name="comment" placeholder="Your comment" required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>




</body>

  <footer class="footer">
    <div class="footer__addr">
      <h1 class="footer__logo"><img src="/assets/img/logo-header.png" width="200"></h1>
          
      <h2>Contact</h2>
      
      <address>
        Aston University<br>Aston St, Birmingham<br> B4 7ET<br>
            
        <a class="footer__btn" href="mailto:example@gmail.com">Email Us</a>
      </address>
    </div>
    
    <ul class="footer__nav">
      <li class="nav__item">
        
        <h2 class="nav__title">Useful Links</h2>
  
        <ul class="nav__ul">
          <li>
            <a href="#">Mens</a>
          </li>
  
          <li>
            <a href="#">Womens</a>
          </li>
              
          <li>
            <a href="#">Featured</a>
          </li>
          <li>
            <a href="#">My Account</a>
  
            <li>
              <a href="#">Sitemap</a>
            </li>
          </li>
        </ul>
      </li>
  
      <li class="nav__item">
        
        <h2 class="nav__title">Newsletter</h2>
  
        <ul class="nav__ul">
          <li>
            <a href="#">Mens</a>
          </li>
  
          <li>
            <a href="#">Womens</a>
          </li>
              
          <li>
            <a href="#">Featured</a>
          </li>
          <li>
            <a href="#">My Account</a>
  
            <li>
              <a href="#">Sitemap</a>
            </li>
          </li>
        </ul>
      </li>
      
  
    
    </ul>
    
    <div class="legal">
      <p>&copy; 2023 ALYX. All rights reserved.</p>
      
      <div class="legal__links">
      </div>
    </div>
  </footer>
  <script>
    document.getElementById('size').addEventListener('change', function() {
        var selectedSize = this.value;
        var stock = this.options[this.selectedIndex].getAttribute('data-stock');
        document.getElementById('quantity').setAttribute('max', stock);
        document.getElementById('stockWarning').innerText = ''; // Clear any previous warning messages
    });

    document.getElementById('add-to-cart-form').addEventListener('submit', function(event) {
        var selectedSize = document.getElementById('size').value;
        var selectedQuantity = document.getElementById('quantity').value;
        var maxStock = document.getElementById('size').options[document.getElementById('size').selectedIndex].getAttribute('data-stock');
        
        if (selectedQuantity > maxStock) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('stockWarning').innerText = 'Selected quantity exceeds available stock.';
        }
    });
</script>
  </html>