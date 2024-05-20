<?php
session_start();
if(!isset($_SESSION['user'])){
  header('location:signin.php');
}
else{
  $user = $_SESSION['user'];
  include './connection.php';
  $getEmail = "SELECT email FROM users where id = $user";
  $emaiQuery = mysqli_query($connection, $getEmail);
  $fetch = mysqli_fetch_assoc($emaiQuery);
  $email = $fetch['email'];
}


$message = "";

if(isset($_POST['add'])){
  include './connection.php';
  $name = $_POST['medicine'];
  $dossage = $_POST['dossage'];
  $metric = $_POST['metric'];
  $dossage2 = $dossage.$metric;
  $date = $_POST['date'];
  $time = $_POST['time'];
  $notificationtype = $_POST['notificationtype'];
  $id = rand(10000, 90000);
  $sendAtTimestamp = strtotime("$date $time UTC");


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

      // later alert 

      require_once './test-email.php';
      


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
    <p style="color:#083C61; text-align:left">Add a new reminder</p>

    <div class="signup">
      <div class="err">
      <p><?php echo $message; ?></p>
      </div>
        <form action="#" method="post">
             <div class="inputs">
        <input type="text" name="medicine" placeholder="medicne" required>
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

        <div class="notified">
            <p>Get notified by</p>
            <input type="radio" id="email" value="email" name="notificationtype" required> <label for="email">Email</label>
            <input type="radio" id="sms"  value="sms" name="notificationtype" required> <label for="sms">SMS</label>
        </div>
       
            </div>

            <div class="button"><button type="submit" name="add">Add</button></div>

          
        
    </div>
</form>

    
</body>
</html>