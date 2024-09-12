<?php
ini_set('display_errors', 0);
session_start();
if(!isset($_SESSION['email'])){
    header("location:forgottenpassword.php");
}
$email = $_SESSION['email'];
$message = "Enter new password";


if(isset($_POST['set'])){
    include './connection.php';
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if($password1 != $password2){
        $message = "<p style='color:red'>Password mismatch</p>";
    }
    else{
         $UPDATE = "UPDATE users SET password = $password1 WHERE email = '$email'";

         if(mysqli_query($connection, $UPDATE)){
            $message = "<p style='color:green'>Password has been set successfully <a href='signin.php'>login</a></p>
            <style>
            .signup{display:none;}
            </style>
            
            ";
            

            
         }
    }

   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>password resset | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Resset password</p>

    <div class="message">
        <p><?php echo $message ?></a></p>
    </div>

    <div class="signup">
        <form action="#" method="post">
             <div class="inputs">
       
        <input type="password" name="password1" placeholder="password" required>
        <input type="password" name="password2" placeholder="confirm password" required>
        
            </div>

            <div class="button"><button type="submit" name="set">set password</button></div>

            <?php

            
            ?>
            
           
        
    </div>
</form>

    
</body>
</html>