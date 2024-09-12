<?php
ini_set('display_errors', 0);
session_start();
if(!isset($_SESSION['user'])){
  header('location:signin.php');
}
else{
  $user = $_SESSION['user'];
  include './connection.php';
  $getEmail = "SELECT email, phone FROM users where id = $user";
  $emaiQuery = mysqli_query($connection, $getEmail);
  $fetch = mysqli_fetch_assoc($emaiQuery);
  $email = $fetch['email'];
  $phone = $fetch['phone'];
  
}
function replaceSpaces($text) {
  
  return str_replace(' ', '%20', $text);
}

function new_sms($SMS, $phone){
 $url = 'https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ&to='.$phone.'&from=MedRemind&sms='.$SMS.'';

 $formatedUrl = replaceSpaces($url);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $formatedUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if ($response === false) {
        echo 'Error: ' . curl_error($ch);
        // echo '<p></p>'.$formatedUrl;
    }
  curl_close($ch);

  
    // echo $response;

      // $curl = curl_init();
      // curl_setopt_array($curl, array(
      // CURLOPT_URL => 'https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ&to='.$phone.'&from=DigiPharm&sms='.$SMS.'',
      // CURLOPT_RETURNTRANSFER => true,
      // CURLOPT_ENCODING => '',
      // CURLOPT_MAXREDIRS => 10,
      // CURLOPT_TIMEOUT => 10,
      // CURLOPT_FOLLOWLOCATION => true,
      // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      // CURLOPT_CUSTOMREQUEST => 'GET', ));
      // $response = curl_exec($curl);
      // curl_close($curl);

      //  echo $response.'<p></p>';
      // echo $formatedUrl;

}

function scheduled_sms($sms,$phone,$datetime){


  $url = replaceSpaces("https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ&to=$phone&from=MedRemind&sms=$sms&schedule=$datetime");


  $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        // echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    // echo $response;

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    // CURLOPT_URL => "https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ=&to=$phone&from=DigiPharm&sms=$sms&schedule=$datetime",
    // CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_ENCODING => '',
    // CURLOPT_MAXREDIRS => 10,
    // CURLOPT_TIMEOUT => 10,
    // CURLOPT_FOLLOWLOCATION => true,
    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_CUSTOMREQUEST => 'GET',
    // ));
    // $response = curl_exec($curl);
    // curl_close($curl);
    // echo $response;

    // echo "https://sms.arkesel.com/sms/api?action=send-sms&api_key=dWd6Vk9xSXNkVUpTUElpR2JweUQ&to=$phone&from=DigiPharm&sms=$sms&schedule=$datetime";
}

function formatDateTime($dateTime) {
 
  $timestamp = strtotime($dateTime);
  
  
  $formattedDate = date('d-m-Y', $timestamp);
  
  
  $formattedTime = date('h:iA', $timestamp);
  
  
  return $formattedDate . ' ' . $formattedTime;
}

$medsSelect = "SELECT medicines from users where id = $user";
$medQury = mysqli_query($connection, $medsSelect);
$medRes = mysqli_fetch_assoc($medQury);
$medicines = $medRes['medicines'];



if(isset($_POST['add'])){
  include './connection.php';
  $name = $_POST['medicine'];
  $dossage = $_POST['dossage'];
  $metric = $_POST['metric'];
  $dossage2 = $dossage.$metric;
  $date = $_POST['date'];
  $time = $_POST['time'];
  
  $id = rand(10000, 90000);
  $sendAtTimestamp = strtotime("$date $time UTC");
  $SMS = "You have set a reminder for medicince intake. Medicine: $name. Dossage: $dossage2. Day : $date. Time: $time. You will be reminded again on $date";

  $Ssms = "You set a reminder for medicince intake at this time.  Medicine: $name. Dossage: $dossage2. Get well soon. DigiPharm";


  $INSERT = "INSERT INTO reminders values($id, '$name', '$dossage', '$date', '$time', $user, '$notificationtype', 'Pending', '$metric')";

  if(mysqli_query($connection, $INSERT)){
      $message = "<p style='color:green'>New reminder has been added.</p>";

      echo '
      <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
      <script>
      // Initialize EmailJS with your user ID
      
      
      emailjs.init("D5Cis1Ws2ayBZZanx");
      
      // Function to send email
      function sendEmail() {
          // Prepare email parameters
          var params = {
              medicine: "'.$name.'",
              user: "'.$email.'",
              dossage: "'.$dossage2.'",
              date: "'.$date.'",
              time: "'.$time.'"
              
          };
      
          // Send email
          emailjs.send("service_s9jf6xp","template_h4er026", params)
              .then(function(response) {
                  console.log("Email sent successfully:", response);
              }, function(error) {
                  console.error("Email sending failed:", error);
              });
      }
      
      // Send the email immediately when the script is loaded
      sendEmail();
      </script>
      
      ' ;
     

      $inputDateTime = $date.$time;
      $converted = formatDateTime($inputDateTime);
      new_sms($SMS, $phone);
      scheduled_sms($Ssms,$phone,$converted);
      
      
      


  }
  else{
    $message = "<p style='red:green'>Something went wrong, try again after some time</p>";
  }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/add.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>Add | Digipharm</title>

    <script>
    // Check if the form has been submitted
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

    
</head>
<body>
<nav>
      <a href="#home" id="logo"><img src="./images/logo-trans.png"></a>
      <input type="checkbox" id="hamburger" />
      <label for="hamburger">
        <i class="fa-solid fa-bars"></i>
      </label>
      <ul>
        <li>
          <a href="dashboard.php" class="active">Home</a>
        </li>


        
        
      </ul>
    </nav>
    <p style="color:white; text-align:left">Add a new reminder</p>

    <div class="signup">
      <div class="err">
      <p><?php echo $message; ?></p>
      </div>
        <form action="#" method="post">
        <div class="inputs">
          <label for="medicine">Medicine</label><span style="color:red">*</span><p></p>

            <?php 
            $medarr = explode(',', $medicines);

            foreach($medarr as $drug){
              echo '
              <input type="radio" id="'.$drug.'" name="medicine"  value="'.$drug.'" required> <label for="'.$drug.'">'.$drug.'</label>';
            }
            ?>

          <p></p>

        <input type="number" name="dossage" placeholder="dossage" required id="don">
         <select required id="dossage" name="metric">
            <option value="mg">mg</option>
            <option value="g">g</option>
            <option value="ml">ml</option>
            <option value="mcg">mcg or μg</option>
            <option value="cc">cc</option>
            <option value="mol">mol</option>
            <option value="mmol">mmol</option>
        </select>
        <input type="date" name="date" placeholder="Date" required id="date" min="<?php echo date('Y-m-d')?>">
        <input type="time" name="time" placeholder="time" required>

      
       
            </div>

            <div class="button"><button type="submit" name="add">Add</button></div>

          
        
    </div>
</form>

    
</body>
</html>