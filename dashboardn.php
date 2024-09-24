<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header('location:signin.php');
}
include './connection.php';
$user = $_SESSION['user'];
$month = $_GET['month'] ?? date('m'); // Get the month from the query string or default to the current month

// reminders fetch 
$SELECT = "SELECT medicine, dossage, time, time2, metric, date FROM reminders WHERE user = $user AND date LIKE '____-$month-__'";
$QUERY = mysqli_query($connection, $SELECT);



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
    <title>Dashboard - MedRemind</title>
    <link href="css2/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="css2/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css2/custom.css" rel="stylesheet" type="text/css"/>

    <style>
        #mra_date_bar {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin: 0 auto;
        }

        #mra_date_bar ul {
            display: flex;
            transition: transform 0.5s ease-in-out;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        #mra_date_bar li {
            flex: 0 0 100px;
            margin-right: 15px;
            text-align: center;
        }

        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 1;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }
      
       #mra_footer{
        margin-top: 100px;
        position:sticky;
        bottom:0;
       }

        <?php  
           if(isset($_GET['day'])){
            $day = $_GET['day'];

            echo '
            .day'.$day.'{
              background-color:blue;
              color:white;
            }
            ';
           }
        
        ?>
    </style>

<script>
    // Function to extract query parameters from the URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Get the day value from the GET request (e.g., ?day=15)
    const dayValue = getQueryParam('day');

    // Create a new style element for button highlighting
    const style = document.createElement('style');
    style.innerHTML = `
        .highlight {
            background: rgb(36, 44, 250);
            border-radius: 6px;
            color: rgb(252, 252, 253);
        }
    `;
    // Append the style element to the head of the document
    document.head.appendChild(style);

    // Highlight the button with the corresponding day if valid
    if (dayValue && dayValue >= 1 && dayValue <= 31) {
        const button = document.querySelector(`button[name="day"][value="${dayValue.padStart(2, '0')}"]`);
        if (button) {
            button.classList.add('highlight');
        }
    }
</script>

    
    <!--  -->
    

    <script>
        // Function to extract query parameters
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Function to get the number of days in a given month and year
        function getDaysInMonth(month, year) {
            return new Date(year, month, 0).getDate(); // 0th day of next month gives last day of the requested month
        }

        // Function to populate the slider with days
        function populateSlider(month) {
            const year = new Date().getFullYear(); // Use the current year
            const daysInMonth = getDaysInMonth(month, year); // Get the number of days in the month
            const slider = document.getElementById('slider'); // Slider element

            // Clear existing items
            slider.innerHTML = '';

            // Populate the slider with days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('li');
                dayElement.innerHTML = `<li> <div>
                    <button name="day" class="day${day}" value="${day}">
                    <span class="medicines">
                                            <span class="color-orange"></span>
                                        </span>
                                        
                        <span class="date">${day}</span>
                        <span class="day">${new Date(year, month - 1, day).toLocaleDateString('en-US', { weekday: 'short' })}</span>
                    </button>
                       
                    </div> 
                    </li>
                `;
                slider.appendChild(dayElement);
            }
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', function() {
            const monthValue = getQueryParam('month') || new Date().getMonth() + 1; // Default to current month if no month is provided
            populateSlider(monthValue);

            let currentIndex = 0;
            const itemsToShow = 6;
            const listItems = document.querySelectorAll('#slider li');
            const totalItems = listItems.length;

            // Function to handle sliding
            function slide(direction) {
                const maxIndex = totalItems - itemsToShow;
                currentIndex += direction;

                if (currentIndex < 0) {
                    currentIndex = 0;
                } else if (currentIndex > maxIndex) {
                    currentIndex = maxIndex;
                }

                const offset = currentIndex * (listItems[0].offsetWidth + 15); // 15px is the margin-right
                document.getElementById('slider').style.transform = `translateX(-${offset}px)`;
            }

            document.querySelector('.prev').addEventListener('click', () => slide(-1));
            document.querySelector('.next').addEventListener('click', () => slide(1));
        });
    </script>

<script>
        // Function to extract query parameters from the URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Get the month value from the GET request (e.g., ?month=01)
        const monthValue = getQueryParam('month');

        // Map of month values to their corresponding class names
        const monthMap = {
            '01': 'jan',
            '02': 'feb',
            '03': 'mar',
            '04': 'apr',
            '05': 'may',
            '06': 'jun',
            '07': 'jul',
            '08': 'aug',
            '09': 'sep',
            '10': 'oct',
            '11': 'nov',
            '12': 'dec'
        };

        // Check if the month value exists in the map
        if (monthValue && monthMap[monthValue]) {
            // Get the corresponding class name for the month
            const className = monthMap[monthValue];

            // Create a new style element
            const style = document.createElement('style');
            style.innerHTML = `
                .${className} {
                    background: rgb(36, 44, 250);
                    border-radius: 6px;
                    color: white;
                }
            `;
            // Append the style element to the head of the document
            document.head.appendChild(style);
        }




       
    </script>

    


</head>
<body>
    <div class="container-fluid">
        <!-- Start Section Header Bar -->
        <section id="mra_header_bar" class="col-12">
            <div class="row">
                <div class="col-8 mra_header_title">My reminders</div>
                <div class="col-4 mra_header_icon"><i class="fa fa-cog"></i><a href="logout.php">logout</a></div>
            </div>
        </section>
        <!-- End Section Header Bar -->

        <!-- Start Section Months Bar -->
        <form action="#?month=<?php echo $_GET['month']?>&day=<?php echo $_GET['day']?>" method="get">
            
            <section id="mra_months_bar" class="col-12">
                <div class="row">
                    <div class="col-12 months">
                        <ul>
                            <li><button name="month" class="jan" value="01">January</button></li>
                            <li><button name="month" class="feb" value="02">February</button></li>
                            <li><button name="month" class="mar" value="03">March</button></li>
                            <li><button name="month" class="apr" value="04">April</button></li>
                            <li><button name="month" class="may" value="05">May</button></li>
                            <li><button name="month" class="jun" value="06">June</button></li>
                            <li><button name="month" class="jul" value="07">July</button></li>
                            <li><button name="month" class="aug" value="08">August</button></li>
                            <li><button name="month" class="sep" value="09">September</button></li>
                            <li><button name="month" class="oct" value="10">October</button></li>
                            <li><button name="month" class="nov" value="11">November</button></li>
                            <li><button name="month" class="dec" value="12">December</button></li>
                        </ul>
                    </div>
                </div>
            </section>
        
        <!-- End Section Months Bar -->

        <!-- Start Section Date Slider -->
        <section id="mra_date_bar" class="col-12">
            <button type="button" class="prev">&#10094;</button>
            <div class="row">
                <div class="col-12">
                    <ul id="slider">
                        <!-- Days of the month will be dynamically populated here -->
                    </ul>
                </div>
            </div>
            </form>
            <button type="button" class="next">&#10095;</button>
        </section>
        <!-- End Section Date Slider -->

        <!-- Start Section Body -->
        <section id="mra_body" class="col-12">
            <?php 
            if ($QUERY->num_rows == 0) {
                echo 'You have no reminders on selected date.';
            } else {
                echo '
                    <div class="row mra_body_header">
                        <div class="col-3">Time</div>
                        <div class="col-9">Medicine</div>
                    </div>';

                while ($RES = mysqli_fetch_assoc($QUERY)) {
                    $status = (checkFutureDate($RES['date']) == 'Pending') ? 'false' : 'true';
                    echo '
                        <div class="row mra_body_data color-violet">
                            <div class="col-3">
                                <ul>
                                    <li>' . $RES['time'] . '</li>
                                    <li>' . $RES['time2'] . '</li>
                                </ul>
                            </div>
                            <div class="col-9">
                                <div class="medicine_info">
                                    <span class="m_icon">
                                        <img src="imgs/capsule.png" alt="">
                                    </span>
                                    <span class="m_info">
                                        <span class="m_name">' . $RES['medicine'] . '</span>
                                        <span class="m_dosage">pills (' . $RES['dossage'] . ' ' . $RES['metric'] . ')</span>
                                        <span class="m_time">
                                            <i class="fa fa-clock-o"></i>&nbsp;' . $RES['time'] . ' - ' . $RES['time2'] . '
                                        </span>
                                    </span>
                                    <span class="m_status ' . $status . '">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    
                                    <span class="cancel"><a href="cancel.php?id='.$res['reminder_id'].'">'.checkFutureDate($dateTime)['cancelStatus'].'</a></span> 
            
                                    <span class="edit"><a href="edit.php?id='.$res['reminder_id'].'">'.checkFutureDate($dateTime)['editStatus'].'</a></span></b></p>


                                </div>
                            </div>
                        </div>';
                }
            }
            ?>
        </section>
        <!-- End Section Body -->
    <!-- Start Section Footer -->

    <section id="mra_footer" class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <li class="active">
                                    <i class="fa fa-bell-o"></i> 
                                    <span>Reminders</span>
                                </li>
                                
                                <li>
                                <a href="dashboard.php#health"><i class="fa fa-user-md">My Health Issues</i></a>
                                    <span>Treatments</span>
                                </li>
                                <li>
                                    <a href="dashboard.php#pres"><i class="fa fa-user-o"> My Prescriptions</i></a>
                                    <span>My Account</span>
                                </li>
                            </ul>
                            <a href="add.php"><button class="btn btn-default btn-lg btnAdd" type="button">
                                <i class="fa fa-plus"></i>
                            </button></a>
                        </div>
                    </div>
                </section>

                <!-- End Section Footer -->
                 
            </div>

        </div>
        










        
        <script src="js/custom.js" type="text/javascript"></script>
    </body>
</html>
