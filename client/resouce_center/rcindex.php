<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if (!isset($_SESSION["rcid"])) {
    
    header("Location: ../Login/staff_login.php");
    
}


$serviceIds = [1, 2, 3, 4, 5, 6, 7, 8, 9];


$placeholders = str_repeat('?,', count($serviceIds) - 1) . '?';

$sql = "SELECT 
            rp.req_id,
            s.s_id,
            CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
            se.serv_name, 
            rp.date_process, 
            st.status,
            rp.rc_process_id,
            s.s_pin,
            r.req_date,
            rp.status_id
        FROM rc_process rp
        INNER JOIN request r ON rp.req_id = r.req_id
        INNER JOIN student s ON r.s_id = s.s_id
        INNER JOIN service se ON r.serv_id = se.serv_id
        INNER JOIN status st ON rp.status_id = st.status_id
        WHERE rp.status_id = 5 OR rp.status_id=17 AND r.serv_id IN ($placeholders)";


$stmt = $pdo->prepare($sql);
$stmt->execute($serviceIds);


$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    <title>Home - Resource Center</title>
</head>
<body>
    <?php include_once "../resouce_center/rcdash.php" ?>

    <div class="box-container" style="margin-top:125px;">
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
            <h1 class="recent-Articles">Recent Recent</h1>
            <button class="view" onclick="refreshPage()">View All</button>
        </div>

        <table id="myTable" class="display">
            <thead>
                <tr class="header">
                    <th style="width:15%;">Student Id</th>
                    <th style="width:20%;">Student Name</th>
                    <th style="width:15%;">Request Name</th>
                    <th style="width:15%;">Date</th>
                    <th style="width:15%;">Status</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($data as $row) {
                    $dateString=$row['req_date'];
                    $timestamp = strtotime($dateString);
                    $formattedDate=date("d/m/Y",$timestamp);
                    echo '<tr>';
                    echo '<td style="text-align: center;"><a href="rc_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['student_name']) . '</td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['serv_name']) . '</td>';
                    echo '<td style="text-align: center;">' . $formattedDate . '</td>';
                    echo '<td style="text-align: center;">';
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
                location.reload(); 
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