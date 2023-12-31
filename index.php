<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html>
  <head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Josefin+Sans:wght@700&family=Lato:wght@300&family=Roboto:wght@100;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Lato:wght@300&family=Roboto:wght@100;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">

    <title>Clothing Store</title>
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
          <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
          <a href="index.php" class="active">Home</a>
          <a href="mens.php">Mens</a>
          <a href="womens.html">Womens</a>
          <a href="featured.html">Featured</a>
          <a href="myaccount.html">
              <?php if (isset($loggedInUser)) : ?>
                  <?php echo $loggedInUser; ?>
              <?php else : ?>
                  Login
              <?php endif; ?>
          </a>
          <a href="contact.html">Contact</a>
      </div>
  </nav>
  


  <div class="hero">
    <div class="hero-content">
        LOOK GOOD,<br>
        FEEL GOOD!<br>
        <a href="#">Shop now</a>
    </div>
</div>

<div class="full-width-section">
  <a href="#featured"><img src="assets/img/arrow-down.png" alt="Logo" width="80px"></a>
  
  <div class="info-box" id="featured">
    Featured items<br>
    <div class="image-container">
      <div class="square-image"><img src="assets/img/outer.png" alt="Logo" width="250px" height="250px"></div>
      <div class="square-image"><img src="assets/img/bottoms.png" alt="Logo" width="250px" height="250px"></div>
      <div class="square-image"><img src="assets/img/accessories.png" alt="Logo" width="250px" height="250px"></div>
      <div class="square-image"><img src="assets/img/shoes.png" alt="Logo" width="250px" height="250px"></div>

    </div>
  </div>
</div>
<div class="full-width-section2">
  <a href="index.html"><img src="assets/img/arrow-down.png" alt="Logo" width="80px"></a>
  <div class="info-box">
    shop by designer<br>
    Explore featured designers<br>

    <div class="image-container">
      <div class="square-image2"><img src="assets/img/rickowens.png" alt="Logo" width="250px"></div>
      <div class="square-image2"><img src="assets/img/kap.png" alt="Logo" width="250px"></div>
      <div class="square-image2"><img src="assets/img/nike.png" alt="Logo" width="250px"></div>
      <div class="square-image2"><img src="assets/img/maison.jpeg" alt="Logo" width="250px"></div>

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
        <li>
          <a href="admin_login.html">Admin Login</a>
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
