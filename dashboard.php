<?php 
ini_set('display_errors', 0);
session_start();

  if(!isset($_SESSION['user'])){
    header('location:signin.php');
  }
  else{
    $user = $_SESSION['user'];
  }

  include './connection.php';
  $SELECT = "SELECT *FROM reminders where user = $user";
  $query = mysqli_query($connection, $SELECT);

  $INFOfetch = "SELECT *FROM users where id = '$user'";
  $infoQuery = mysqli_query($connection, $INFOfetch);
  $infoRes = mysqli_fetch_assoc($infoQuery);

  

  function checkFutureDate($providedDate) {
    $currentDate = date('Y-m-d H:i:s');
     $currentTimestamp = strtotime($currentDate);
     $providedTimestamp = strtotime($providedDate);
 
     
     if ($providedTimestamp > $currentTimestamp) {
          
       return ['editStatus' => "Edit",
       'cancelStatus' => "Cancel",
       'status' => "Pending"];

        
         
     } else {

      return ['editStatus' => "",
      'cancelStatus' => "",
      'status' => "Past"];
     }
 }

  



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Lemonada' rel='stylesheet'>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>Dashboard | Digipharm</title>
</head>
<body>
<!--  -->
    

    <div class="signup">

    <fieldset class="fieldset" id="health">
      <legend><b>My Health</b></legend>
      <p>Health Issues</p>

      
      <?php 

      $illness = $infoRes['healthissues'];
      $arr = explode(',', $illness);

      foreach($arr as $ill){
       
      $color1 = rand(10, 99);
      $color2 = rand(10, 99);
      $color3 = rand(10, 99);
      $color = "rgba(".$color1.",".$color2.",".$color3.",0.9)";
      echo '
      <div class="illness" style="background:  -webkit-linear-gradient('.$color.','.$color.'), url(../images/heartbeat.png);background-repeat: round;"> <a style="text-decoration:none; color:white; text-align:right" href="deletestuff.php?type=hi&name='.$ill.'"><i class="fas fa-trash" style="margin-left:auto"></i></a>
   <h1>'.$ill.'</h1>
    </div> 
        
        ';
      }
      
      
    ?>
    <hr>
    <a href="addhealth.php?type=hs"><button class="add">
      Add +
    </button></a>
    </fieldset>


    <fieldset class="fieldsets" id="pres">
      <legend><b>Prescriptions</b></legend>
      <p></p>

      
      <?php 

      $medicines = $infoRes['medicines'];
      $medi = explode(',', $medicines);

      foreach($medi as $med){
       
      $color1 = rand(10, 99);
      $color2 = rand(10, 99);
      $color3 = rand(10, 99);
      $color = "rgba(".$color1.",".$color2.",".$color3.",0.9)";
      echo '
      <div class="illness" style="background:  -webkit-linear-gradient('.$color.','.$color.'), url(../images/medicine.jpeg);background-repeat: round;"> <a style="text-decoration:none; color:white; text-align:right" href="deletestuff.php?type=med&name='.$med.'"><i class="fas fa-trash"></i></a>
   <h1>'.$med.'</h1>
    </div> 
        
        ';
      }
      
      
    ?>
    <hr>
    <a href="addhealth.php?type=md"><button class="add">
      Add +
    </button></a>
    </fieldset>


    

    

   

   </div>  
    
</body>
</html>