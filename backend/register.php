<?php
        if(isset($_POST['submitted'])){
            require_once('connect_database.php');

            $username = isset($_POST['username'])?$_POST['username']:false;
            $email = isset($_POST['email'])?$_POST['email']:false;
            $hashed_password = isset($_POST['password'])?password_hash($_POST['password'],PASSWORD_DEFAULT):false;
            $fname = isset($_POST['first-name'])?$_POST['first-name']:false;
            $lname = isset($_POST['last-name'])?$_POST['last-name']:false;

            if(!($username)){
                echo "User name is wrong";
                exit;
            }
            if(!($hashed_password)){
                exit('password is wrong');
            }
            try{
                $stat = $db ->prepare("Insert into user values(default,?,?,?,?,?)");
                $stat ->execute(array($username,$hashed_password,$email,$fname,$lname));

                $id = $db ->lastInsertId();
                echo "Congratulations you are now registered your ID is: " . $id;
                header('Location: ../index.html');
            } 
            catch(PDOException $ex){
                echo "Sorry a database error occured";
                echo "Your details are <em>". $ex->getMessage()."</em>";
            }
        }
    ?>