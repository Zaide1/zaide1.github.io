<?php
require_once('connect_database.php');

if(isset($_POST['submitted'])){
    if( !isset($_POST['username'],$_POST['password']) ){
        exit("Please fill both the username and password fields");
    }
    try{

        $username = $_POST['username'];
        $password = $_POST['password'];

    
        $stat = $db->prepare('SELECT password FROM admin_user WHERE username = ?');
        $stat -> execute(array($username));

        if($stat -> rowCount()>0){
            $row=$stat->fetch();

            if(password_verify($password,$row['password'])){
                session_start();
                $_SESSION['username'] = $_POST['username'];
                header("Location:../admin_homepage.html");
                exit();
            } else{
                echo "<p style='color:red'> Error logging in, passwords do not match </p>";
                
            }
        }else{
            echo "<p>Login information incorrect</p>";
        }
    } catch(PDOException $ex){
        echo("Failed to connect to the database <br>");
        echo($ex->getMessage());
        exit;

    }

}
?>
