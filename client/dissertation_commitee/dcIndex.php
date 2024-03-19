<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();

if (!isset($_SESSION['dcid'])) {
    
    header("Location: ../Login/login.php");
    exit();
    
}
$sql ="SELECT 
dp.req_id,
s.s_id,
CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
se.serv_name,
r.req_date AS dt,
st.status,
dp.date_process,
dp.dc_process_id,
s.s_pin
FROM dc_process dp
INNER JOIN request r ON dp.req_id = r.req_id
INNER JOIN student s ON r.s_id = s.s_id
INNER JOIN service se ON r.serv_id = se.serv_id
INNER JOIN status st ON dp.status_id = st.status_id
WHERE dp.status_id =5";
$stmt =$pdo->query($sql);
$stmt->execute();
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
        <title>Dissertation Committee</title>
        
<body>
<?php include_once "../dissertation_commitee/dc_dash.php"; ?>



<div class="report-container"  style="margin-top:125px;">
    <div class="report-header">
        <h1 class="recent-Articles">Recent Request</h1>

    </div>

    <table id="myTable" class="display">
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
        
        foreach ($data as $row) {
            $date=date("d/m/Y", strtotime(htmlspecialchars($row['dt'])));
            echo '<tr>';
            echo '<td style="text-align: center;"><a href="dc_viewform.php?q=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td class="text-center">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td class="text-center">' . $date . '</td>';
            echo '<td class="text-center">' ;
            echo '<button type="button" class="btn btn-warning">';
            echo htmlspecialchars($row['status']) . '</button></td>';
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
