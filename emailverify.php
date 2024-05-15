<?php
session_start();
$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$link = $_SERVER['SERVER_NAME']."/activation/index.php?id=".$id."&email=".$email;

echo '
<script src="https://cdn.emailjs.com/dist/email.min.js"></script>
<script>
// Initialize EmailJS with your user ID


emailjs.init("vqYyv2J3u7inIVDaR");

// Function to send email
function sendEmail() {
    // Prepare email parameters
    var params = {
        activation_link: "'.$link.'",
        new_user: "'.$email.'"
        
    };

    // Send email
    emailjs.send("service_jgap5ij", "template_he4u3hn", params)
        .then(function(response) {
            console.log("Email sent successfully:", response);
        }, function(error) {
            console.error("Email sending failed:", error);
        });
}

// Send the email immediately when the script is loaded
sendEmail();
</script>

'
;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>verify | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>

    <div class="email-image">
        <img src="./images/email.png">
    </div>

    <p> You have successfully created an
account, open your email to verify 
your account. </p>
    

    

   

    
</body>
</html>