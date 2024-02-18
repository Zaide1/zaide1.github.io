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
    require_once('backend/connect_database.php');

    $items = []; // Initialize an array to store the items
    $query = $db->query("SELECT product_name, default_price,product_id FROM product WHERE category_id = 1");
    if ($query) {
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row; // Store each item in the array
      }
    }
  ?>
   <nav class="navbar">
      <div class="logo">
          <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
          <a href="index.php" >Home</a>
          <a href="mens.php">Mens</a>
          <a href="womens.php" class="active">Womens</a>
          <a href="cart.php">Basket</a>
          <a href="myaccount.php">
              <?php if (isset($loggedInUser)) : ?>
                  <?php echo $loggedInUser; ?>
              <?php else : ?>
                  Login
              <?php endif; ?>
          </a>
          <a href="contact.html">Contact</a>
      </div>
  </nav>
  
  <div class="hero-women" >
    <div  class="hero-content" >
       WOMENS
        
    </div>
</div>

<div class="Items">

  <?php foreach ($items as $item) : ?>
    <?php
    $image_directory = 'assets/img/' . $item['product_name'] . '.webp'; // images are in webp format
    $default_image = 'assets/img/outer.png'; // Default image path if product image not found
    $image_path = file_exists($image_directory) ? $image_directory : $default_image; // Set image source based on existence
    ?>
    <div class="Item">
      <a href="items_buy.php?id=<?php echo htmlspecialchars($item['product_id']); ?>" class="Item__link">
        <div class="ImageContainer">
          <img src="<?php echo $image_path; ?>" alt="Item Image" width="400px" height="400px" class="Image">
        </div>
        <div class="Item__title"><?php echo $item['product_name']; ?></div>
        <div class="Item__price">£ <?php echo $item['default_price']; ?></div>
      </a>
    </div>
  <?php endforeach; ?>
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
