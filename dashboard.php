<?php 
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
    
    <title>Dashboard | Digipharm</title>
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

        <li>
          <a href="add.php" class="active">New reminder</a>
        </li>

        <li>
          <a href="logout.php" class="active">logout</a>
        </li>

       
        
        
      </ul>
    </nav>
  
    

    <div class="signup">
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