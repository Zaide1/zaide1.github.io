<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="http://localhost/zaide1.github.io-main/assets/css/main.css">

    <title>Alyx Clothing</title>
    
</head>
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
<body>
    <?php 
    session_start();
   // var_dump($_SESSION);
    if(isset($_POST['submitted'])){
        require_once('backend/connect_database.php');

        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page or display an error message
            header("Location: login.html");
            exit;
        }
        $user_id = $_SESSION['user_id']; // Assuming you have a user_id stored in the session
        $street = isset($_POST['street_name'])?$_POST['street_name']:false;
        $city = isset($_POST['city'])?$_POST['city']:false;
        $post_code = isset($_POST['post_code'])?$_POST['post_code']:false;
        $country = isset($_POST['country'])?$_POST['country']:false;


        
        $sql = "INSERT INTO user_address (user_id, address_id, is_default,street_name,city,post_code,country) VALUES ($user_id,DEFAULT,TRUE, '$street', '$city', '$post_code','$country')";
        $stat = $db ->prepare($sql);
        $stat ->execute();
        $address_id = $db->lastInsertId();

        $_SESSION['address_id'] = $address_id;
        header("Location: payment.php");
        exit;
    }            
    ?>
    <form action="address.php" method="post">
        <label for="street_name">Street Name</label>
            <input type="text" id='street_name' name='street_name' required>
        <label for="city">City</label>
            <input type="text" id='city' name='city' required>
        <label for="post_code">Post/Zip Code</label>
            <input type="text" id='postcode' name='post_code' required>
        <label for="country">Country</label><span style="color: red !important; display: inline; float: none;">*</span>      
            <select id="country" name="country" class="form-control" required>
            <option value="GB">United Kingdom</option>
            <option value="AL">Albania</option>
            <option value="AD">Andorra</option>
            <option value="AT">Austria</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BG">Bulgaria</option>
            <option value="HR">Croatia (Hrvatska)</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="FR">France</option>
            <option value="GI">Gibraltar</option>
            <option value="DE">Germany</option>
            <option value="GR">Greece</option>
            <option value="VA">Holy See (Vatican City State)</option>
            <option value="HU">Hungary</option>
            <option value="IT">Italy</option>
            <option value="LI">Liechtenstein</option>
            <option value="LU">Luxembourg</option>
            <option value="MK">Macedonia</option>
            <option value="MT">Malta</option>
            <option value="MD">Moldova</option>
            <option value="MC">Monaco</option>
            <option value="ME">Montenegro</option>
            <option value="NL">Netherlands</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="RO">Romania</option>
            <option value="SM">San Marino</option>
            <option value="RS">Serbia</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="ES">Spain</option>
            <option value="UA">Ukraine</option>
            <option value="DK">Denmark</option>
            <option value="EE">Estonia</option>
            <option value="FO">Faroe Islands</option>
            <option value="FI">Finland</option>
            <option value="GL">Greenland</option>
            <option value="IS">Iceland</option>
            <option value="IE">Ireland</option>
            <option value="LV">Latvia</option>
            <option value="LT">Lithuania</option>
            <option value="NO">Norway</option>
            <option value="SJ">Svalbard and Jan Mayen Islands</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="TR">Turkey</option>
            </select>

            <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Proceed to Payment</button>
            <input type="hidden" value="true" name='submitted'>

    </form>
</body>
</html>