<?php
  session_start();
  // Check if the user is logged in
  if (isset($_SESSION['username'])) {
      $loggedInUser = $_SESSION['username'];
      // Flag to indicate if the welcome banner should be shown
      $showWelcomeBanner = true;
      // Unset the session variable to avoid showing the banner again on page refresh
      unset($_SESSION['username']);
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
    <style>
        .welcome-banner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #4CAF50; 
            color: white;
            text-align: center;
            padding: 20px;
            z-index: 9999; 
            display: none; 
        }
    </style>
  </head>
  <body>
    <!-- Add the welcome banner -->
    <?php if (isset($showWelcomeBanner) && $showWelcomeBanner) : ?>
      <div class="welcome-banner" id="welcomeBanner">Welcome, <?php echo $loggedInUser; ?>!</div>
    <?php endif; ?>  

    <nav class="navbar">
      <div class="logo">
          <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
        <form class="form-inline my-2 my-lg-0" action = "search_result.php" method="GET">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="<?php echo htmlspecialchars('search'); ?>">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
          <input type='hidden' name="<?php echo htmlspecialchars('submitted'); ?>">
          
        </form>
          <a href="index.php" class="active">Home</a>
          <a href="mens.php">Mens</a>
          <a href="womens.php">Womens</a>
          <a href="cart.php">Basket</a>
          <a href="myaccount.php">My Account</a>
<a href="">
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
      <a href="./mens.php">
        <div class="square-image"><img src="assets/img/outer.png" alt="Logo" width="250px" height="250px"></div>
      </a>
      <a href="./mens.php">
        <div class="square-image"><img src="assets/img/bottoms.png" alt="Logo" width="250px" height="250px"></div>
      </a>
      <a href="./womens.php">
        <div class="square-image"><img src="assets/img/accessories.png" alt="Logo" width="250px" height="250px"></div>
      </a>
      <a href="./womens.php">
        <div class="square-image"><img src="assets/img/shoes.png" alt="Logo" width="250px" height="250px"></div>
      </a>

    </div>
  </div>
</div>
<div class="full-width-section2">
  <a href="index.php"><img src="assets/img/arrow-down.png" alt="Logo" width="80px"></a>
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

  <script>
    // Function to show the welcome banner and hide it after 5 seconds
    function showWelcomeBanner() {
        var welcomeBanner = document.getElementById('welcomeBanner');
        welcomeBanner.style.display = 'block';
        // setTimeout(function() {
        //     welcomeBanner.style.display = 'none';
        // }, 5000); // Hide after 5 seconds
    }

    // Call the function when the page is loaded
    window.onload = function() {
        showWelcomeBanner();
    };
  </script>
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
