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
    <nav class="navbar">
      <div class="logo">
         <a href="index.html"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
          <a href="index.html" >Home</a>
          <a href="mens.html" class="active">Mens</a>
          <a href="womens.html">Womens</a>
          <a href="featured.html">Featured</a>
          <a href="myaccount.html">My Account</a>
          <a href="login.html" >Login</a>
          <a href="contact.html">Contact</a>
      </div>
  </nav>
  <div class="hero-mens" onclick="window.location.href='mens_inventory.html';" style="cursor: pointer;">
    <div  class="hero-content" >
       MENS
        
    </div>
</div>
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

  <!-- Displaying the fetched items in an unordered list -->
  <ul>
  <?php foreach ($items as $item) : ?>
    <li>
      <div class="square-image">
        <a href="product.php?id=<?php echo htmlspecialchars($item['product_id']); ?>">
          <img src="assets/img/outer.png" alt="<?php echo $item['product_name']; ?>" width="250px" height="250px">
        </a>
      </div>
      <a href="items_buy.php?id=<?php echo htmlspecialchars($item['product_id']); ?>">
        <?php echo $item['product_name']; ?> - $<?php echo $item['default_price']; ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

  
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
