<?php
ini_set('display_errors', 0);
$id = $_GET['id'];
$message = "Are you sure you want to cancel this reminder?";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>Cancel | Digipharm</title>

      <?php
        if(isset($_POST['yes'])){
            include './connection.php';
            $DELETE = "DELETE FROM reminders WHERE reminder_id = $id";
            if(mysqli_query($connection, $DELETE)){
                $message = "<p style='color:green'>Reminder has been deleted successfully</p>
                
                <style>
                .button{
                    display:none;
                </style>
                
                ";

                header("refresh:5;url=dashboard.php");

            }

        }
        elseif(isset($_POST['no'])){
            header("location:dashboard.php");
        }
        ?>





</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Cancel Reminder</p>

    

    <div class="signup">
        <p><?php echo $message ?></p>
        <form action="#" method="POST">
             <div class="inputs">
       
            
            </div>

            <div class="button">
            <button type="submit" name="yes" id="button" style="background-color:#074102; margin-bottom:10px">Yes</button>
            <button type="submit" name="no" id="button" style="background-color:#591204">No</button>
            </div>
            
           
        
    </div>
</form>

    
</body>
</html>