<?php
require_once('connect_database.php');

if(isset($_POST['submitted'])){
    if( !isset($_POST['username'],$_POST['password']) ){
        exit("Please fill both the username and password fields");
    }
    try{

        $username = $_POST['username'];
        $password = $_POST['password'];

    
        $stat = $db->prepare('SELECT user_id, Password FROM user WHERE Username = ?');
        $stat -> execute(array($username));

        if($stat -> rowCount()>0){
            $row=$stat->fetch();

            if(password_verify($password,$row['Password'])){
                session_start();
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location:../index.php");
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
