<?php
ini_set('display_errors', 0);
session_start();
if(!isset($_SESSION['user'])){
    header('location:signin.php');
  }

  if(!isset($_GET['id'])){
    header('location:dashboard.php');
  }
  $message = "";
  
    $user = $_SESSION['user'];
    $id = $_GET['id'];
    include './connection.php';
    $idSELECT = "SELECT *FROM reminders where reminder_id = $id";
    $idquery = mysqli_query($connection, $idSELECT);
    $res = mysqli_fetch_assoc($idquery);

    if(isset($_POST['edit'])){

      $name = $_POST['medicine'];
  $dossage = $_POST['dossage'];
  $metric = $_POST['metric'];
  $dossage2 = $dossage.$metric;
  $date = $_POST['date'];
  $time = $_POST['time'];
  $notificationtype = $_POST['notificationtype'];


  $UPDATE = "UPDATE reminders set medicine = '$name', dossage='$dossage', date='$date', time='$time', notificationType='$notificationtype', metric='$metric' where reminder_id=$id";

  

  if(mysqli_query($connection, $UPDATE)){
    $message = "<p style='color:green'>Reminder has been updated</p>";
  }

    }

    $medsSelect = "SELECT medicines from users where id = $user";
    $medQury = mysqli_query($connection, $medsSelect);
    $medRes = mysqli_fetch_assoc($medQury);
    $medicines = $medRes['medicines'];
    
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/add.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>Edit | Digipharm</title>

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
    <p style="color:#083C61; text-align:left">Edit reminder</p>

    <div class="signup">
      <div class="err"><?php echo $message ?></div>
        <form action="#" method="post">
             <div class="inputs">
              <p>Medicines</p>
             <?php 
            $medarr = explode(',', $medicines);
            
            echo '<input type="radio" id="'.$drug.'" name="medicine"  value="'.$res['medicine'].'" checked required> <label for="'.$drug.'">'.$res['medicine'].'</label>';
            

            foreach($medarr as $drug){
              echo '
              <input type="radio" id="'.$drug.'" name="medicine"  value="'.$drug.'" required> <label for="'.$drug.'">'.$drug.'</label>';
            }
            ?>

      <p>Dossage</p>
        <input type="number" name="dossage" placeholder="dossage" required id="don" value="<?php echo $res['dossage'] ?>">
         <select required id="dossage" name="metric">
          <option value="<?php echo $res['metric'] ?>">mg</option>
          <option value="mg">mg</option>
            <option value="g">g</option>
            <option value="ml">ml</option>
            <option value="mcg">mcg or μg</option>
            <option value="cc">cc</option>
            <option value="mol">mol</option>
            <option value="mmol">mmol</option>
        </select>

        <p>Date</p>
        <input type="date" name="date" placeholder="Date" required value="<?php echo $res['date'] ?>">
        <p>Time</p>
        <input type="time" name="time" placeholder="time" required value="<?php echo $res['time'] ?>">

        <!-- <div class="notified">
            <p>Get notified by</p>
            <input type="radio" id="email" name="notificationtype" requied <?php echo ($res['notificationType'] ==  "email") ? "checked" : ""  ?> value="email"> <label for="email">Email</label>
            <input type="radio" id="sms" name="notificationtype" requied  <?php echo ($res['notificationType'] ==  "sms") ? "checked" : ""  ?> value="sms"> <label for="sms">SMS</label>
        </div> -->
       
            </div>

            <div class="button"><button type="submit" name="edit">Edit</button></div>

          
        
    </div>
</form>

    
</body>
</html>