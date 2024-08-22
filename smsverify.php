<?php
session_start();
$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$customer = $_SESSION['phone'];



$message = "You have successfully created an
account, check your phone for SMS verifcation code.";
$API_KEY = 'dWd6Vk9xSXNkVUpTUElpR2JweUQ';


$SMS = "Your verification code is $id. Enter it to activate your account.";

function sms(){

    $id = $_SESSION['userid'];
$email = $_SESSION['email'];
$customer = $_SESSION['phone'];
$SMS = "Your verification code is $id. Enter it to activate your account.";
    
// SEND SMS
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ&to='.$customer.'&from=DigiPahrm&sms='.$SMS.'',
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

sms();

if(isset($_POST['submit3'])){

    $code = $_POST['code'];

   if($code == $id){
    header("location: ./activation/index.php?id=$id&email=&email");
   }

   else{
    $message = "Incorrect code";
    sms($SMS, $customer);
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
       
             <input type="number" name="code" placeholder="enter code" required id="code2">
            <div class="button"><button type="submit" name="submit3" id="code2">Submit</button><div>

        </form>
        

    </div>


    <?php  
    
    
    ?>

</body>
</html>