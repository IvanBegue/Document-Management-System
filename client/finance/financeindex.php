<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if (!isset($_SESSION['fid'])) {
    
    header('Location: ../login/staff_login.php'); 

}


// Define an array of service IDs for the request names you want to view
$serviceIds = [1, 2, 3, 4, 5, 6, 7, 8, 9]; 

// Create placeholders for the service IDs
$placeholders = str_repeat('?,', count($serviceIds) - 1) . '?';

$sql = "SELECT 
            fp.req_id,
            s.s_id,
            CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
            se.serv_name, 
            fp.date_process, 
            st.status,
            fp.f_process_id,
            s.s_pin,
            r.req_date,
            fp.status_id
        FROM finance_process fp
        INNER JOIN request r ON fp.req_id = r.req_id
        INNER JOIN student s ON r.s_id = s.s_id
        INNER JOIN service se ON r.serv_id = se.serv_id
        INNER JOIN status st ON fp.status_id = st.status_id
        WHERE fp.status_id = 5 OR fp.status_id = 17 AND r.serv_id IN ($placeholders)";

// Prepare and execute the SQL query with the array of service IDs
$stmt = $pdo->prepare($sql);
$stmt->execute($serviceIds);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finance Department</title>
</head>
<body>
    <?php include_once "../finance/finance_dash.php" ?>

    <div class="box-container" style="padding-top:125px;">
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

    <div class="report-container" style="margin-top:125px;">
        <div class="report-header">
            <h1 class="recent-Articles">Recent Request</h1>
        
            
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
                //Loop through the data array and populate the table rows
                foreach ($data as $row) {
                    $dateString=$row['req_date'];
                    $timestamp = strtotime($dateString);
                    $formattedDate=date("d/m/Y",$timestamp);
                    echo '<tr>';
                    echo '<td class="text-center text-capitalize"><a href="finance_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
                    echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['student_name']) . '</td>';
                    echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['serv_name']) . '</td>';
                    echo '<td class="text-center text-capitalize">' .  $formattedDate . '</td>';
                    echo '<td class="text-center text-capitalize">' ;
                    if($row["status_id"]==17){
                        echo '<button class="btn btn-secondary">'.htmlspecialchars($row['status']) .'</button>';
                    }else{
                        echo '<button class="btn btn-warning">'.htmlspecialchars($row['status']) .'</button>';
                    }   
                    
                    
                    echo '</td>';
                    
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