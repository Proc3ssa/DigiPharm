<?php
if(isset($_GET['id']) and isset($_GET['email'])){
    include '../connection.php';
$id = $_GET['id'];
$email = $_GET['email'];

$UPDATE = "UPDATE users set status = 'verified' where id = $id and email = '$email'";

    if(mysqli_query($connection, $UPDATE)){
        $message = "Your account has been verified successfully <a href='../signin.php'>login</a>";
    }
    else{
        $message = "<p style='color:gray'>Error: link has expired</p>";
    }

}
else{
    $message = "<p style='color:red'>Error: something is wrong with this link</p>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    
    <title>verify | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="../images/logo-colored.png">
    </div>

    <div class="email-image">
        <img src="../images/email.png">
    </div>

    <p><?php echo $message ?></p>
    

    

   

    
</body>
</html>