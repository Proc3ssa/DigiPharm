<?php
$message = "";
?>
<?php
if(isset($_POST['create'])){
    include './connection.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $healthissues = $_POST['hi'];
    $medications = $_POST['medications'];
    $other = $_POST['other'];
    $medicine = $medications.",".$other;

    $SELECT = "SELECT *FROM users WHERE email = '$email'";
    $QUERY = mysqli_query($connection, $SELECT);

    if($QUERY -> num_rows != 0){
       $message = "Email is already taken";
       ;
    }
    else{
        $id = rand(10000, 900000);
        $INSERT = "INSERT INTO users value($id, '$name', $age, '$email', '$phone', '$password', 'notverified', '$healthissues', '$medicine')";

        if(mysqli_query($connection, $INSERT)){

            session_start();
            $_SESSION['userid'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            header("location:smsverify.php");
        }
        else{
            echo '<script>alert("Something went wrong, try again after sometime")</script>';
        }
        
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
    
    <title>Signup | Digipharm</title>
    <script>
    // Check if the form has been submitted
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

    <script>
    function toggleDropdown() {
        document.getElementById("dropdown-content").classList.toggle("show");
    }

    var checkboxes = document.querySelectorAll('#dropdown-content input[type="checkbox"]');
    var textbox = document.getElementById('selected-options');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var selected = [];
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }
            });
            textbox.value = selected.join(', ');
        });
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown button')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }


    function validatePassword() {
        var password = document.getElementById('password').value;
        var message = document.getElementById('passwordMessage');

        if (password.length < 8) {
            message.style.display = 'block';  // Show the message
        } else {
            message.style.display = 'none';  // Hide the message
        }
    }

    function healthdetails(){
        document.getElementById('hd').style.display = "block";

        document.getElementById('nothd').style.display = "none";
    }
</script>

<style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 12px;
            border-radius: 4px;
        }

        .dropdown-content label {
            display: block;
            cursor: pointer;
        }

        .dropdown-content input[type="checkbox"] {
            margin-right: 10px;
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }

        .dropdown button:focus {
            outline: none;
        }

        #selected-options {
            width: 94%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>
    <p>Sign up</p>

    <div class="signup">
    <div class="err">
            <?php echo $message?>
    </div>
        <form action="#" method="post">
        <fieldset id='nothd'>
        <legend>Personal Details</legend>

        <div class="inputs">
         
        <label for="name">Name</label><a class='required'>*</a>
        <input type="text" name="name" id='name' placeholder="Enter you name" required>

        <label for="age">Age</label><a class='required'>*</a>
        <input type="number" name="age" id='age' placeholder="Enter you age" required>

        <label for="email">Email</label><a class='required'>*</a>
        <input type="email" name="email" id='email'placeholder="Enter your email" required>

        <label for="password">Password</label><a class='required'>*</a>
        <p id="passwordMessage" style="color: red; display: none; font-size:15px">Password must be at least 8 characters long.</p>

        <input type="password" name="password" id='password' placeholder="Enter password" onchange="validatePassword()" required>

        <label for="phone">Phone</label><a class='required'>*</a>
        <input type="text" name="phone"  placeholder="+233       0456xxxx" required>

        <label for="name">Gender</label><a class='required'>*</a>
        <select required name="gender">
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
            </div>

        </fieldset>

        <fieldset id='hd' >
            <legend>Health Details</legend>
<p></p>
            <label for="hi">Health Issues(seperate list with ',')</label><a class='required'>*</a>
           <input type="text" name="hi" id='hi' placeholder="(e.g, cancer, diabetes, asthma)" required>

   <p></p>
           <label for="prescriptions">Medications</label><a class='required'>*</a>

           
           <!--  -->
           <div class="dropdown">
    <button type="button" onclick="toggleDropdown()">Select Options</button>
    <div id="dropdown-content" class="dropdown-content">
        <label><input type="checkbox" value="panadol">Panadol</label>
        <label><input type="checkbox" value="Insuline">Insuline</label>
        <label><input type="checkbox" value="Amoxicillin">Amoxicillin</label>
        <label><input type="checkbox" value="Vitamin B complex">Vitamin B complex</label>
    </div>
</div>

<input type="text" id="selected-options" name="medications" placeholder="Selected options will appear here...">


           <!--  -->

            <p></p>
           <label for="other">Other</label>
           
           <input type="text" name="other" id='other' placeholder="other medicine" value="">
        
            
        </fieldset>

        

            <div class="button">
            
            <button id="hd" type="submit" name="create">Create account</button></div>

           <b>Already have an account? <a href="signin.php"> Sign in</a></b>
          
        
    </div>
</form>


<script>
    function toggleDropdown() {
        document.getElementById("dropdown-content").classList.toggle("show");
    }

    var checkboxes = document.querySelectorAll('#dropdown-content input[type="checkbox"]');
    var textbox = document.getElementById('selected-options');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var selected = [];
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selected.push(checkbox.value);
                }
            });
            textbox.value = selected.join(', ');
        });
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown button')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
    
</body>
</html>