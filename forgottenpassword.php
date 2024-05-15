<?php

session_start();
$message = "Enter your email address to recieve a reset code";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>forgotten password | Digipharm</title>

      <?php
        if(isset($_GET['submit'])){
            include './connection.php';
            $email = $_GET['email'];
            $code = rand(1000, 9999);
            
            $_SESSION['code'] = $code;
            echo $_SESSION['code'];
        
            // check email validity 
        
            $SELECT = "SELECT *FROM users where email = '$email'";
            $query = mysqli_query($connection, $SELECT);
        
           
        
            if($query -> num_rows != 0){
            $message = "A code has been sent to your email, enter it";

            echo '

            <style>
            #code{
                display:block;
            }
            #code2{
                display:none;
            }
            </style>
           
            
            </script>
            <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
            <script>
            // Initialize EmailJS with your user ID
            
            
            emailjs.init("vqYyv2J3u7inIVDaR");
            
            // Function to send email
            function sendEmail() {
                // Prepare email parameters
                var params = {
                    reset_code: '.$code.',
                    user: "'.$email.'",
                    from_name: "DigiPharm"
                    
                };
            
                // Send email
                emailjs.send("service_jgap5ij", "template_7ubb34y", params)
                    .then(function(response) {
                        console.log("Email sent successfully:", response);
                    }, function(error) {
                        console.error("Email sending failed:", error);
                    });
            }
            
            // Send the email immediately when the script is loaded
            sendEmail();

           

            </script>
                
        
            ';
           }
           else{
            $message = "Error: unknown email";
           }
        
        }

        if(isset($_POST['verify'])){
            
            $realCode = $_SESSION['code'];
            $code = $_POST['code'];

            if($code === $realCode){
                $message = "Code has been verified";
                header('refresh:3;url=newpassword.php');
            }
            else{
                $message = "Wrong code";
               
            }

        }

        ?>





</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Resset password</p>

    

    <div class="signup">
        <p><?php echo $message ?></p>
        <form action="#" method="get">
             <div class="inputs">
       
             <input type="email" name="email" placeholder="Email" required id="code2">


             <div class="button"><button type="submit" name="submit" id="code2">Send Code</button><div>

        </form>
        <form method="post" action="#">

             <input type="number" name="code" placeholder="Enter code" required id="code">
       
           
        
            </div>

            
            <div class="button"><button type="submit" name="verify" id="code">Verify code</button></div>

           
           
        
    </div>
</form>

    
</body>
</html>