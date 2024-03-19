<?php
session_start();
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
if(!isset($_SESSION["hid"])){  //*Redirect To Login
    header("Location: ../Login/staff_login.php");
}  

$sql = "SELECT 
hp.req_id,
s.s_id,
CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
se.serv_name, 
st.status,
r.req_date,
hp.hos_process_id,
s.s_pin
FROM hos_process hp
INNER JOIN request r ON hp.req_id = r.req_id
INNER JOIN student s ON r.s_id = s.s_id
INNER JOIN service se ON r.serv_id = se.serv_id
INNER JOIN status st ON hp.status_id = st.status_id
WHERE  hp.hos_id=:id";
// Prepare and execute the SQL query with the staff member's ID as a parameter
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":id"=>$_SESSION["hid"]));

// Fetch all data from the query result and store it in an array
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize an array to store service counts
$serviceCounts = array();

// Calculate service counts based on fetched data
foreach ($data as $row) {
    $servName = $row['serv_name'];
    
    // Check if the servName exists in the $serviceCounts array
    if (array_key_exists($servName, $serviceCounts)) {
        // Increment the count for the corresponding servName
        $serviceCounts[$servName]++;
    } else {
        // If the servName is not in the array, add it and initialize the count to 1
        $serviceCounts[$servName] = 1;
    }
}
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--Boostrap Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <title>Head Of School</title>
        <link rel="stylesheet" href="../hos/hos.css" />


        <!-- Data Table Start -->
        <!-- Add these links to include DataTables CSS and JavaScript -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
        

        <script  src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
       


        <!-- Data Table End-->
            

    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="../hos/images/UTM.png" alt="Description of the image"></i>
        </div>

        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
           
            <i class='bx bx-bell'></i>
            <a href="../hos/dc_pass.php"> <!-- Add the URL you want to navigate to -->
        
      </a>
        </div>
        
        </nav> 

        <header>
  <h1>Head of School</h1>
</header>


<div class="box-container">
    <?php
    foreach ($serviceCounts as $serviceName => $count) {
        if ($count > 0) {
            echo '<div class="box box1 box-a" data-service="' . $serviceName . '">';
            echo '<div class="text">';
            echo '<h2 class="topic-heading">' . $count . '</h2>';
            echo '<h2 class="topic">' . $serviceName . '</h2>';
            echo '</div>';
            echo '<img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png" alt="Views">';
            echo '</div>';
        }
    }
    ?>
</div>




<div class="report-container" >
    <div class="report-header">
        <h1 class="recent-Articles">Recent Request</h1>
        <button class="view" onclick="refreshPage()">View All</button>
    </div>

    <table id="myTable" class="display" >
    <thead>
        <tr class="header">
            <th style="width:15%;">Student ID</th>
            <th style="width:20%;">Student Name</th>
            <th style="width:15%;">Request Name</th>
            <th style="width:15%;">Date</th>
            <th style="width:15%;">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // Loop through the data array and populate the table rows
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td style="text-align: center;"><a href="dc_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['req_date']) . '</td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['status']) . '</td>';
            
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>


<script>

function refreshPage() {
    location.reload(); // Reload the current page
}


// Get all box containers
const boxContainers = document.querySelectorAll('.box');

// Add click event listener to each box container
boxContainers.forEach(function(box) {
    box.addEventListener('click', function() {
        // Retrieve the service name from the data-service attribute
        const serviceName = box.getAttribute('data-service');

        // Filter the table to show only rows with the selected service name
        filterTableByService(serviceName);
    });
});

// Function to filter the table by service name
function filterTableByService(serviceName) {
    const tableRows = document.querySelectorAll('#myTable tbody tr');

    // Loop through all table rows
    tableRows.forEach(function(row) {
        // Check if the row contains the selected service name
        const cell = row.querySelector('td:nth-child(3)'); // Assuming service name is in the second column
        if (cell) {
            const cellText = cell.textContent || cell.innerText;
            if (cellText === serviceName) {
                // Show the row
                row.style.display = '';
            } else {
                // Hide the row
                row.style.display = 'none';
            }
        }
    });
}


$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

</div>
</div>
</div>


<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="../hos/hos_dash.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
        <li class="item">
            <a href="../hos/hos_history.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-history"></i>
                </span>
                <span class="navlink">Request History</span>
            </a>
        </li>
            <!--
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bxs-user-plus'></i>
                    </span>
                    <span class="navlink text-wrap text-center">New Program Coordinator</span>
                </a>
            </li>-->
            <li class="item">
                <a href="../hos/hos_pass.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-cog"></i>
                    </span>
                    <span class="navlink">Change Password</span>
                </a>
            </li>
                
<li class="item">
    <a href="../Login/logout.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-exit"></i>
        </span>
        <span class="navlink">Log Out</span>
    </a>
</li>
    
        
    </ul>

    </ul>

    <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(hos_lname, ' ', hos_fname) AS FN FROM hos where  hos_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["hid"]));
            $rowFN=$stmtFN->fetch(PDO::FETCH_ASSOC);


        ?>
            
        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span><?php echo htmlspecialchars($rowFN["FN"])?></span>
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </nav>
<script>
    function myFunction() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>

<!-- JavaScript -->
<script src="/client/script.js"></script>
<script src="home.js"></script>
</body>
</html>