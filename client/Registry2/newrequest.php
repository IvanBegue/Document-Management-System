<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();
if(!isset($_SESSION["rid"])){
    header("Location: ../Login/staff_login.php");
}

$sql="SELECT rp.req_id, CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, se.serv_name, r.req_date, st.status ,s.s_pin,rp.status_id,rp.serv_id
FROM request rp 
INNER JOIN request r ON rp.req_id = r.req_id 
INNER JOIN student s ON r.s_id = s.s_id 
INNER JOIN service se ON r.serv_id = se.serv_id 
INNER JOIN status st ON rp.status_id = st.status_id 
AND st.status_id = 5 ORDER BY r.req_id DESC";
$stmt=$pdo->query($sql);
$stmt->execute();
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <title>Document Management System</title>


</head>
<body>
    <?php include_once "../Registry2/RegistryDashboard.php"; ?>

    <div class="report-container" style="margin-top:125px;">
        <div class="report-header">
            <h1 class="recent-Articles">New Request</h1>
            
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr class="header">
                    <th style="width:20%;">Student Name</th>
                    <th style="width:15%;">Student ID</th>
                    <th style="width:15%;">Request Name</th>
                    <th style="width:15%;">Date</th>
                    <th style="width:15%;">Status</th>
                    <th style="width:30%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through the data array and populate the table rows
                foreach ($rows as $row) {
                    $date=strtotime(htmlspecialchars($row['req_date']));
                    $currentDate = date("d/m/Y",$date);
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['student_name']) . '</td>';
                echo '<form method="POST" action="registryviewform.php?q=' . $row['req_id'] . '">';
                echo '<td>';
                echo '<button   type="submit"   class=" btn btn-link text-dark">';
                echo htmlspecialchars($row["s_pin"]) ;
                echo '</button>';
                '</td>';
                echo '</form>';
                echo '<td>' . htmlspecialchars($row['serv_name']) . '</td>';
                echo '<td>' . $currentDate . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>';
                
                
                if(($row['status_id'])==5 && ($row['serv_id'])!=12){
                    echo '<form method="POST" action="clearanceProcess.php">';
                        echo '<button type="submit" class="btn btn-warning" name="btnclr"  value="'.htmlspecialchars($row["req_id"]).'" >Request Clearance</button>';
                    echo '</form>';
                }elseif(($row['status_id'])==11){
                    echo '<form method="POST" action="NotifyStudent.php">';
                    echo '<button type="submit" name="btnsubmit" class="btn btn-success">Notify Student To Collect</button>';
                    echo  '<input type="hidden" name="id" value="'.htmlspecialchars($row["req_id"]).'" >';
                    echo '</form>';
                
                }elseif(($row['status_id'])==7){
                    echo '<form method="POST" action="NotifyStudent.php">';
                    echo '<button type="submit" name="btndenied" class="btn btn-primary">Denied Request</button>';
                    echo  '<input type="hidden" name="id" value="'.htmlspecialchars($row["req_id"]).'" >';
                    echo '</form>';
                }elseif(($row['serv_id'])==12 &&($row['status_id'])==5){
                        echo '<form method="POST" action="clearanceProcess.php">';
                            echo '<button type="submit" class="btn btn-warning" name="btnclr"  value="'.htmlspecialchars($row["req_id"]).'" >Sent To student Affairs</button>';
                        echo '</form>';
                }else{
                    echo '<button type="submit" class="btn btn-primary">none</button>';
                }
                
                /*
                echo '<button class="approve-button" name="btnapprove" value="' . $row['req_id'] . '">Approve</button>';
                echo '<button class="decline-button" name="btndel"  value="' . $row['req_id'] . '"  onclick="showPopup()">Decline</button>';
                
                echo '<button type="submit" class="submit-button" name="submit to Programme "  value="Submit to Program Coordinator">Submit</button>'; */ 
                // Added submit button
                
                echo '</td>';
                echo '</tr>';
                }
                ?>
                
                    
                
            </tbody>
        </table>
        <p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>

        <script>
            

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