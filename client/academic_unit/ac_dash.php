<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';

if (!isset($_SESSION['acid'])) {
    
    header('Location: ../Login/login.php'); 
    
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
        <title>Academic Unit</title>
        <link rel="stylesheet" href="../css/style.css" />

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
            <img src="../academic_unit/images/UTM.png" alt="Description of the image"></i>
            
        </div>
        <h1 class="text-secondary" style="margin-left:50px;">ACADEMIC DEPARTMENT</h1>


        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            
            <i class='bx bx-bell'></i>
           
      </a>
        </div>
        
        </nav> 







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




<!-- sidebar -->
<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="./acindex.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
        <li class="item">
                <a href="./ac_history.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>
            <li class="item">
    <a href="./ac_pass.php" class="nav_link">
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
 
        <!-- end -->
    </ul>

    </ul>

    <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(acu_lname, ' ', acu_fname) AS FN FROM academic_unit where  acu_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["acid"]));
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
