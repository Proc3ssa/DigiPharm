<?php
$message = "";
?>
<?php
if(isset($_POST['create'])){
    include './connection.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $SELECT = "SELECT *FROM users WHERE email = '$email'";
    $QUERY = mysqli_query($connection, $SELECT);

    if($QUERY -> num_rows != 0){
       $message = "Email is already taken";
       ;
    }
    else{
        $id = rand(10000, 900000);
        $INSERT = "INSERT INTO users value($id, '$name', '$email', '$phone', $password, 'notverified')";

        if(mysqli_query($connection, $INSERT)){

            session_start();
            $_SESSION['userid'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            header("location:smsverify.php");
        }
        else{
            echo '<script>alert("Something went wrong, try again after sometime")</script>';
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
    
    <title>Signup | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Sign up</p>

    <div class="signup">
    <div class="err">
            <?php echo $message?>
        </div>
        <form action="#" method="post">
             <div class="inputs">
        <input type="text" name="name" placeholder="name" required>
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="text" name="phone" placeholder="+233       0456xxxx" required>
        <select required name="gender">
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
            </div>

            <div class="button"><button type="submit" name="create">Create account</button></div>

           <b>Already have an account? <a href="signin.php"> Sign in</a></b>
          
        
    </div>
</form>



    
</body>
</html>