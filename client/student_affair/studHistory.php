<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
if (!isset($_SESSION['said'])) {
    
    header('Location: ../login/login.php'); 
    
}


$sql = "SELECT 
            stp.req_id, 
            s.s_pin,
            CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
            se.serv_name, 
            r.req_date, 
            stp.status_id,
            st.status
        FROM student_affairs_process stp
        INNER JOIN request r ON stp.req_id = r.req_id
        INNER JOIN student s ON r.s_id = s.s_id
        INNER JOIN service se ON r.serv_id = se.serv_id
        INNER JOIN status st ON stp.status_id = st.status_id
        WHERE stp.status_id <> 5 AND stp.sa_id=:said";


// Prepare and execute the SQL query with the staff member's ID as a parameter
$stmt = $pdo->prepare($sql);

$stmt->execute(array(":said"=>$_SESSION['said']));

// Fetch all data from the query result and store it in an array
$approvedDeclinedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>student affairs</title>

    </head>
    <body>
        
    <?php  include_once "../student_affair/stud_affair_dash.php";  ?>

    <div class="report-container" style="margin-top:125px;">
        <div class="report-header">
            <h1 class="recent-Articles">Recent Request</h1>
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
        foreach ($approvedDeclinedData as $row) {
            $timestamp = strtotime($row['req_date']);
            $formattedDate = date("d-m-Y", $timestamp);
            echo '<tr';

           
            $statusId = $row['status_id'];

          

            echo '>';
            
            echo '<td style="text-align: center;"><a href="stud_affair_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td class="text-center">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td class="text-center">' . $formattedDate  . '</td>';
            
            echo '<td class="text-center">';
            if ($statusId == 1) {
               
                echo '<button type="button" class="btn btn-success">'. htmlspecialchars($row['status']) . '</button>';
            } else {
                echo '<button type="button" class="btn btn-danger">'. htmlspecialchars($row['status']) . '</button>';
            } 

            echo '</td></tr>';
        }

        ?>
    </tbody>
</table>
<p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>





</body>
</html>
