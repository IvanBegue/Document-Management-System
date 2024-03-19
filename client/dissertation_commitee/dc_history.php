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
dp.status_id,
dp.dc_process_id,
s.s_pin
FROM dc_process dp
INNER JOIN request r ON dp.req_id = r.req_id
INNER JOIN student s ON r.s_id = s.s_id
INNER JOIN service se ON r.serv_id = se.serv_id
INNER JOIN status st ON dp.status_id = st.status_id
WHERE st.status_id <>5 AND dp.dc_id=:id";
$stmt =$pdo->prepare($sql);
$stmt->execute(array(":id"=>$_SESSION['dcid']));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <title>Dissertation Committee</title>
        
<body>
<?php include_once "../dissertation_commitee/dc_dash.php"; ?>



<div class="report-container">
    <div class="report-header">
        <h1 class="recent-Articles">Request History</h1>
        
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
        // Loop through the data array and populate the table rows
        foreach ($data as $row) {
            $date=date("d/m/Y", strtotime(htmlspecialchars($row['dt'])));
            echo '<tr>';
            echo '<td style="text-align: center;"><a href="dc_viewform.php?q=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td class="text-center">' . $date . '</td>';
            echo '<td class="text-center">' ;
            if($row["status_id"]==1)
            {
                echo '<button type="button" class="btn btn-success">';
                echo htmlspecialchars($row['status']) . '</button>';
            }else{
                echo '<button type="button" class="btn btn-danger">';
                echo htmlspecialchars($row['status']) . '</button>';
            }
            
            echo '</td></tr>';
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
