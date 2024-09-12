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
<nav>

<a style="margin-left:10px; text-align:center" class='profile' href="profile.php" id="logo"><img src="./images/user.png" /> <p><?php echo $infoRes['name']; ?></p></a>

      <!-- <a href="#home" id="logo"><img src="./images/logo-trans.png"></a> -->
      <input type="checkbox" id="hamburger" />
      <label for="hamburger">
        <!-- <i class="fa-solid fa-bars"></i> -->
      </label>
      <ul>
        <li>
          <a href="dashboard.php" class="active">Home</a>
        </li>

        <li>
          <a href="add.php" class="active">New reminder</a>
        </li>

        <li>
          <a href="logout.php" class="active">logout</a>
        </li>

       
        
        
      </ul>
    </nav>
  
    

    <div class="signup">

    <fieldset class="fieldset">
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


    <fieldset class="fieldsets">
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

<p style="color:#083C61; text-align:left; margin-top:100px;">Reminders</p>

     <?php

     while($res = mysqli_fetch_assoc($query)){

      $dateTime = $res['date'].' '.$res['time'];
      $medicine = $res['medicine'];
      
        $color1 = rand(10, 99);
        $color2 = rand(10, 99);
        $color3 = rand(10, 99);
        $color = "rgba(".$color1.",".$color2.",".$color3.",0.5)";
        echo '

    <div class="reminder" style="background-color:'.$color.';">
        <div class="top">
            <b id="medname">'.(strlen($medicine) <13 ? $medicine : substr($medicine, 0, 12) . '...').'</b> <b id="dossage">Dossage:<span class="sd">'.$res['dossage'].$res['metric'].'</span></b>
        </div>
        <hr/>

        <div class="botom">
            <p><b>Date: <span class="sdd">'.$res['date'].'</span> <span class="status">'.checkFutureDate($dateTime)['status'].'<span></b></p>

            <p style="margin-top:-17px"><b>Time: <span class="st">'.$res['time'].'</span> 
            <span class="cancel"><a href="cancel.php?id='.$res['reminder_id'].'">'.checkFutureDate($dateTime)['cancelStatus'].'</a></span> 
            
            <span class="edit"><a href="edit.php?id='.$res['reminder_id'].'">'.checkFutureDate($dateTime)['editStatus'].'</a></span></b></p>

           
        </div>

    </div>

    ';
     }

     if($query -> num_rows == 0){
        echo "You have no reminders";
     }
    ?>

    

   

   </div>  
    
</body>
</html>