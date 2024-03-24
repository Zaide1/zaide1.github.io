
<nav class="navbar">
  <div class="logo">
      <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
  </div>
  <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="mens.php">Mens</a>
      <a href="womens.php">Womens</a>
      <a href="cart.php" class="active">Basket</a>
      <a href="myaccount.php">My Account</a>
      <a href="login.html">Login</a>
      <a href="contact.html">Contact</a>
  </div>
</nav>

<style>
  /* Reset some default styles */
  body {
      margin: 0;
      padding: 0;
  }

  /* Style the navbar */
  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #0f1108;
    padding: 10px; /* Adjust the padding */
    height: 80px; /* Adjust the height */
    font-family: 'Josefin Sans', sans-serif;
  font-family: 'Lato', sans-serif;
  font-family: 'Roboto', sans-serif;
  text-transform: uppercase;
  z-index: 2;


  }

  /* Style the logo */
  .logo img {
    max-width: 250px; /* Increase the maximum width */
    height: auto; /* This ensures the aspect ratio is maintained */
  }

  .logo {
    margin-bottom: 40px; /* Adjust the margin as needed */
  }
  /* Style the navigation links */
  .nav-links a {
    color: #f2f2f2;
    text-decoration: none;
    margin-left: 20px;
    font-size: 17px;
    padding-left: 1.5vh;
    padding-right: 1.5vh;
  }
  .nav-links a:hover {
    color: #2da6bb; /* Change this to the color you want on hover */
  }
  .nav-links a.active {
    text-decoration: underline; /* Change this to the color you want for active links */
    color: #2da6bb;
  }

  /* Media query for responsiveness */
  @media screen and (max-width: 768px) {
      .navbar {
          flex-direction: column;
          align-items: flex-start;
          height: auto;
      }

      .nav-links {
          margin-top: 10px;
      }

      .nav-links a {
          margin: 5px 0;
      }
  }
</style>