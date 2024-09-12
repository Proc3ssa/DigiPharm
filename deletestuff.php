<?php 
ini_set('display_errors', 0);

session_start();
if(!isset($_SESSION['user'])){
    header('location:signin.php');
  }
  else{
    $user = $_SESSION['user'];
  }

$type = $_GET['type'];
$name = $_GET['name'];

$DELETE ="";
include './connection.php';
if($type == "hi"){
    
    $healthSelect = "SELECT healthissues FROM users WHERE id = $user";
    $healthQuery = mysqli_query($connection, $healthSelect);
    $healthres = mysqli_fetch_assoc($healthQuery);
    $healthissues = $healthres['healthissues'];

   
    $newhealthissues = str_replace(",$name", "", $healthissues);
    $DELETE = "UPDATE users SET healthissues = '$newhealthissues' WHERE id = $user";
    if(mysqli_query($connection, $DELETE)){

        echo '
         <script>alert("Health issue deleted")
         window.location.href = "dashboard.php";
    
         </script>
        ';

        
    }
    

}
else{

    $medSelect = "SELECT medicines FROM users WHERE id = $user";
    $medQuery = mysqli_query($connection, $medSelect);
    $medres = mysqli_fetch_assoc($medQuery);
    $medicines = $medres['medicines'];

   
    $newMedicines = str_replace(",$name", "", $medicines);
    $DELETE = "UPDATE users SET medicines = '$newMedicines' WHERE id = $user";
    if(mysqli_query($connection, $DELETE)){

        echo '
         <script>alert("Medicine deleted")
         window.location.href = "dashboard.php";
    
         </script>
        ';

        
    }
    
}

?>