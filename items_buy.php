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
    <link rel="stylesheet" href="http://localhost/zaide1.github.io/assets/css/main.css">

    <title>Clothing Store</title>
  </head>
  <body>

  <?php
try{
    require_once('backend/connect_database.php');

    // Check if the 'id' parameter exists in the URL
    if (isset($_GET['id'])) {
        // Sanitize and retrieve the product ID from the URL
        $product_id = htmlspecialchars($_GET['id']);

        $stat = $db ->prepare("SELECT product_name, category_id, description, default_price FROM product WHERE product_id = :id;");
        $stat->bindParam(':id', $product_id);
        $stat->execute();

        if($stat->rowCount() > 0){
            $row = $stat->fetch();
        } else{
            echo 'Item not found';
        }

        $sizes_stmt = $db->prepare('SELECT pe.size_id, s.size_name FROM product_entry pe INNER JOIN sizes s ON pe.size_id = s.size_id WHERE pe.product_id = :id;');
        $sizes_stmt->bindParam(':id', $product_id);
        $sizes_stmt->execute();

        if ($sizes_stmt->rowCount() > 0) {
            $sizes = $sizes_stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo 'Sizes not found for this product';
        }
    }
} catch(PDOException $e){
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
            $image_directory = 'http://localhost/zaide1.github.io/assets/img/' . $row['product_name'] . '.webp'; // images are in webp format
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
                      <form method="post" action="add_cart.php">
                          <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                          <label for="size">Available sizes:</label>
                          <select name="size">
                            <?php foreach ($sizes as $size) : 
                              $keyAsString = strval($size['size_id']); ?>
                              <option value="<?php echo $keyAsString; ?>"><?php echo $size['size_name']; ?></option>
                            <?php endforeach; ?>
                          </select>
                          <button type="submit">Add to Cart</button>
                      </form>
                    </div>
                </div>
        </div>
    </div>
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
  </html>