<?php
session_start();
$id = $_SESSION['userid'];
$email = $_SESSION['email'];


$message = "You have successfully created an
account, check your phone for SMS verifcation code.";
$API_KEY = 'dWd6Vk9xSXNkVUpTUElpR2JweUQ';

$code = rand(99999,100000);
$SMS = "Your verification code is $code. Enter it to activate your account.";

function sms(){
    
// SEND SMS
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://sms.arkesel.com/sms/api?action=send-sms&api_key=cE9QRUkdjsjdfjkdsj9kdiieieififiw=&to=233544919953&from=Arkesel&sms=Hello%20world.%20Spreading%20peace%20and%20joy%20only.%20Remeber%20to%20put%20on%20your%20face%20mask.%20Stay%20safe!',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 10,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET', ));
$response = curl_exec($curl);
curl_close($curl);
echo $response;

}



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
    <p>Account Activation</p>

    

    <div class="signup">
        <p><?php echo $message ?></p>
        <form action="#" method="POST">
             <div class="inputs">
       
             <input type="email" name="email" placeholder="enter code" required id="code2">
            <div class="button"><button type="submit" name="submit" id="code2">Submit</button><div>

        </form>
        

    </div>

</body>
</html>