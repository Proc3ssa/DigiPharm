<?php
session_start();
if(isset($_SESSION['user'])){
    header('location:dashboard.php');
}

$message = "";
if(isset($_POST['login'])){
    include './connection.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    $Count = "SELECT * from users WHERE email = '$email' and password = '$password'";

    $query = mysqli_query($connection, $Count);
    $fetch = mysqli_fetch_assoc($query);

    if($query -> num_rows != 0){
        if($fetch['status'] == "verified"){
        session_start();
        $_SESSION['user'] = $fetch['id'];
        header("location:dashboard.php");
        }
        else{
            $message = "<p style='color:blue'>Your Account has not been verified. Check your email for a verification message.</p>";
        }
    }
    else{
       $message = "<p style='color:red'>Wrong user details</p>";

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
    
    <title>Signin | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Sign up</p>

    <div class="signup">
        <div class="err">
            <p><?php echo $message; ?></p>
        </div>
        <form action="#" method="post">
             <div class="inputs">
       
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        
            </div>

            <div class="button"><button type="submit" name="login">Login</button></div>
            
            <div class="refs">
           <b>Don't have an account? <a href="signup.php"> Sign up</a></b>
           <p align="center" style="text-align:center"><a href="forgottenpassword.php">forgotten password?</a></p>
            </div>
        
    </div>
</form>

<?php

?>

    
</body>
</html>