<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if (!isset($_SESSION["rcid"])) {

    header("Location: ../Login/staff_login.php");
    
}



$sql = "SELECT 
            rp.req_id, 
            s.s_pin,
            CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
            se.serv_name, 
            r.req_date, 
            st.status_id,
            st.status,
            rp.status_id
            FROM rc_process rp
            INNER JOIN request r ON rp.req_id = r.req_id
            INNER JOIN student s ON r.s_id = s.s_id
            INNER JOIN service se ON r.serv_id = se.serv_id
            INNER JOIN status st ON rp.status_id = st.status_id AND rp.status_id <> 5";



$stmt = $pdo->query($sql);

$stmt->execute();

// Fetch all data from the query result and store it in an array
$approvedDeclinedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Request History </title>
    </head>
    <body>
    
    <?php include_once "../resouce_center/rcdash.php" ?>

<div class="report-container" style="margin-top:125px;">
    <div class="report-header">
        <h1 class="recent-Articles">Request History</h1>
        <button class="view" onclick="refreshPage()">View All</button>
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
        foreach ($approvedDeclinedData as $row) {
            echo '<tr';

            // Check the status_id and apply inline style accordingly
            $statusId = $row['status_id'];

            if ($statusId == 8) {
                echo ' style="background-color: #a9dfbf;"'; // Green background
            } elseif ($statusId == 7) {
                echo ' style="background-color: #f2b5b5;"'; // Red background
            }

            echo '>';
            
            echo '<td style="text-align: center;"><a href="rc_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['req_date']) . '</td>';
            echo '<td class="text-center">'; 
            if($row["status_id"]==17){
                echo '<button class="btn btn-secondary">'.htmlspecialchars($row['status']) .'</button>';
            }else{
                echo '<button class="btn btn-success">'.htmlspecialchars($row['status']) .'</button>';
            }
            '</td>';
        

            echo '</tr>';
        }

        ?>
    </tbody>
</table>
<p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>

        <script>

    // Function to filter the table by service name
    function filterTableByService(serviceName) {
        const tableRows = document.querySelectorAll('#myTable tbody tr');

        // Loop through all table rows
        tableRows.forEach(function (row) {
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


</body>
</html>
