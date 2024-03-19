<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/pdo.php";

if(!isset($_SESSION["euid"])){  //*Redirect To Login
    header("Location: ../login/staff_login.php");
}   


// Define an array of service IDs for the request names you want to view
$serviceIds = [1, 2, 3, 4, 5, 6, 7, 8, 9]; 

// Create placeholders for the service IDs
$placeholders = str_repeat('?,', count($serviceIds) - 1) . '?';

$sql = "SELECT EU.eu_process_id,r.req_id,r.req_date,eu.status_id,sv.serv_name,s.status,CONCAT(st.s_lname,' ',st.s_fname)AS FN ,st.s_pin From exam_unit_process EU , request r ,service sv ,status s ,student st WHERE EU.req_id=r.req_id and EU.status_id=s.status_Id and r.serv_id=sv.serv_id and r.s_id =st.s_id and eu.status_id <>5";

// Prepare and execute the SQL query with the array of service IDs
$stmt=$pdo->query($sql);


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
    <title>Request History</title>
</head>
<body>
<?php include_once "../exam_unit/exam_dash.php"; ?>

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
                //Loop through the data array and populate the table rows
                foreach ($data as $row) {
                    $dateString=$row['req_date'];
                    $timestamp = strtotime($dateString);
                    $formattedDate=date("d/m/Y",$timestamp);
                    echo '<tr>';
                    echo '<td class="text-center text-capitalize"><a href="exam_viewform.php?q=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
                    echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['FN']) . '</td>';
                    echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['serv_name']) . '</td>';
                    echo '<td class="text-center text-capitalize">' .  $formattedDate . '</td>';
                    echo '<td class="text-center text-capitalize">' ;
                    if($row["status_id"]==5){
                        echo '<button class="btn btn-warning">'.htmlspecialchars($row['status']) .'</button>';
                    }else{
                        echo '<button class="btn btn-success">'.htmlspecialchars($row['status']) .'</button>';
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