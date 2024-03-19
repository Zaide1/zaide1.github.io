<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyx Clothing</title>
</head>
<body>
    
<?php 
session_start();
var_dump($_SESSION);

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

    // Check if the address already exists for the user
    $sql = "SELECT address_id FROM user_address WHERE user_id = :user_id AND street_name = :street AND city = :city AND post_code = :post_code AND country = :country";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':post_code', $post_code);
    $stmt->bindParam(':country', $country);
    $stmt->execute();
    $existing_address = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_address) {
        // Use the existing address_id
        $address_id = $existing_address['address_id'];
    } else {
        // Insert a new address
        $sql = "INSERT INTO user_address (user_id, address_id, is_default, street_name, city, post_code, country) VALUES (:user_id, DEFAULT, TRUE, :street, :city, :post_code, :country)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':post_code', $post_code);
        $stmt->bindParam(':country', $country);
        $stmt->execute();
        $address_id = $db->lastInsertId();
    }

    // Store the address_id in the session
    $_SESSION['address_id'] = $address_id;

    header("Location: payment.php");
    exit;
}
?>

    <form action="address.php" method="post">
        <label for="street_name">Street Name</label>
            <input type="text" id='street_name' name='street_name'>
        <label for="city">City</label>
            <input type="text" id='city' name='city'>
        <label for="post_code">Post/Zip Code</label>
            <input type="text" id='postcode' name='post_code'>
        <label for="country">Country</label><span style="color: red !important; display: inline; float: none;">*</span>      
            <select id="country" name="country" class="form-control">
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