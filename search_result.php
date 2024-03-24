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
    ?>
    
   <nav class="navbar">
      <div class="logo">
          <a href="index.php"><img src="assets/img/logo-header.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
        <form class="form-inline my-2 my-lg-0" action="search_result.php" method = "GET">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="<?php echo htmlspecialchars('search'); ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
		    <input type='hidden' name="<?php echo htmlspecialchars('submitted'); ?>">
        </form>
          <a href="index.php" >Home</a>
          <a href="mens.php"class="active">Mens</a>
          <a href="womens.php">Womens</a>
          <a href="cart.php">Basket</a>
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
  <?php
    

    // Prepare the SQL statement with named placeholders
$query = $db->prepare("SELECT product_name, default_price, product_id, `description` FROM product WHERE product_name LIKE :search_query OR `description` LIKE :search_query");

// Bind the search query to the named placeholder
$search_query = '%' . $_GET['search'] . '%';
$query->bindParam(':search_query', $search_query, PDO::PARAM_STR);

// Execute the prepared statement
$query->execute();

// Fetch the results
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $items[] = $row; // Store each item in the array
}
  ?>
  
  <div class="hero-mens" >
    <div  class="hero-content" >
       MENS
        
    </div>
</div>

<div class="filter-options">
    <label for="sort">Sort by:</label>
    <select id="sort" onchange="handleChange(this)">
        <!--- Makes sure the dropdown is on the version currently selected -->
        <option value="low_to_high" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'low_to_high') echo 'selected'; ?>>Price: Low to High</option>
        <option value="high_to_low" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'high_to_low') echo 'selected'; ?>>Price: High to Low</option>
    </select>
</div>

<script>
    function handleChange(select) {
        // Get the selected sorting option
        var selectedOption = select.value;
        
        // Construct the new URL with the sorting parameter
        var url = window.location.href.split('?')[0]; // Get the current URL without parameters
        if (selectedOption) {
            url += '?sort=' + selectedOption;
        }
        
        // Reload the page with the new URL
        window.location.href = url;
    }
</script>

<div class="Items">

<?php 
if (!empty($items)) {
    // Sort the items based on the selected option
    $sorted_items = $items; 
    
    // Check if sort option is selected
    if (isset($_GET['sort'])) {
        $sort_option = $_GET['sort'];
        if ($sort_option === 'low_to_high') {
            usort($sorted_items, function($a, $b) {
                return $a['default_price'] - $b['default_price'];
            });
        } elseif ($sort_option === 'high_to_low') {
            usort($sorted_items, function($a, $b) {
                return $b['default_price'] - $a['default_price'];
            });
        }
    }

    foreach ($sorted_items as $item) {
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
    <?php
    }
} else {
    echo "No results found.";
}
?>


  
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
