<?php
ini_set('display_errors', 0);
session_start();
if(!isset($_SESSION['user'])){
  header('location:signin.php');
}
else{
    if($_GET['type'] == 'hs'){
        $healthtype = "Health Issues";
        $examples = "Cancer, diabetes, asthma";
    } 
    else{
        $healthtype = "Medication";
        $examples = "Insuline, vitamines, paracetamol";
    }

  $user = $_SESSION['user'];
  include './connection.php';
 
  
}

if(isset($_POST['add'])){
  include './connection.php';
  $HS = $_POST['hs'];
  
  if($_GET['type'] == 'hs'){

    $hs = "SELECT healthissues from users WHERE id = $user";
    $hsQuery = mysqli_query($connection, $hs);
    $res = mysqli_fetch_assoc($hsQuery);

    $halthissue = $res['healthissues'];
    $updated = $halthissue.",".$HS;

    $UPDATE = "UPDATE users set healthissues = '$updated' where id = $user";
} 
else{
    $hs = "SELECT medicines from users WHERE id = $user";
    $hsQuery = mysqli_query($connection, $hs);
    $res = mysqli_fetch_assoc($hsQuery);

    $halthissue = $res['medicines'];
    $updated = $halthissue.",".$HS;

    $UPDATE = "UPDATE users set medicines = '$updated' where id = $user";
}


  
  if(mysqli_query($connection, $UPDATE)){
      $message = "<p style='color:green'>New $healthtype has been added.</p>";

      
      
      
      


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
    <p style="color:white; text-align:center">Add a new <b><?php  echo $healthtype ?></b></p>

    <div class="signup">
      <div class="err">
      <p><?php echo $message; ?></p>
      </div>
        <form action="#" method="post">
             <div class="inputs">
                <label for="health"><?php echo $healthtype ?>, (use ',' to seperate them)<span style="color:red">*</span></label>
        
                <input type="text" id="health" name="hs" placeholder="(e.g <?php echo $examples ?> etc)" required>
        

      
       
            </div>

            <div class="button"><button type="submit" name="add">Add</button></div>

          
        
    </div>
</form>

    
</body>
</html>