<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyx Clothing</title>
</head>
<body>
    <?php
    session_start();

    // Unset the session variable "username"
    unset($_SESSION['username']);

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: index.php');
    exit;
    ?>
</body>

</html>