<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
session_start();


if (!isset($_SESSION['said'])) {
    header('Location: ../login/login.php'); 

}



$sql = "SELECT 
    sap.req_id,
    s.s_id,
    CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
    se.serv_name, 
    st.status,
    r.req_date,
    sap.s_a_process_id,
    s.s_pin,
    s.s_umail 
FROM student_affairs_process sap
INNER JOIN request r ON sap.req_id = r.req_id
INNER JOIN student s ON r.s_id = s.s_id
INNER JOIN service se ON r.serv_id = se.serv_id
INNER JOIN status st ON sap.status_id = st.status_id
WHERE st.status_id = 5 ";




// Prepare and execute the SQL query with the staff member's ID as a parameter
$stmt = $pdo->query($sql);
$stmt->execute();

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


if (isset($_POST["btnapprove"])) {
    try {
        // Get the req_id from the posted value
        $reqId =$_POST["btnapprove"];
        
        $todayDate = date("Y-m-d");
        // Update the status_id in student_affairs_process
        $updateStudAffairSql = "UPDATE student_affairs_process SET status_id = 1, date_process = :dt  sa_id = :said WHERE req_id = :id";
        $updateStudAffairStmt = $pdo->prepare( $updateStudAffairSql);
        $updateStudAffairStmt->execute(array(":id" => $reqId, ":dt" => $todayDate,":said"=>$_SESSION['said']));

        ChangeRegistStatus();
        ChangeRequestStatus();
        

        
        // SENDING EMAIL TO STUDENT AFTER PROCESSING REQUEST
        $studentEmail = $data[0]['s_umail'];  // Assuming umail is the student's email
        $emailSubject = "Change of Personal Informations";
        $emailBody = "Dear Student, your request is currently in process. <br>
        <br> You are requested to bring a proof of address to the Student Affairs to proceed with your request.";
        $studentName = $data[0]['student_name'];  
        sendEmail($studentEmail, $emailSubject, $emailBody, $studentName);

         // Redirect to the appropriate page after processing
         header("location: ../student_affair/stud_affair_dash.php");
        
     } catch (Exception $e) {
         // Handle any exceptions that may occur during the database operations
         error_log('Error: ' . $e->getMessage());
         header("location: ../student_affair/stud_affair_dash.php");
     }
 }
 function ChangeRegistStatus(){
    global $reqId ,$pdo;
 // Update the status_id in registry_process
 $updateRegistryProSql = "UPDATE registry_process SET status_id = 1 WHERE req_id = :id";
 $updateRegistryProStmt = $pdo->prepare($updateRegistryProSql);
 $updateRegistryProStmt->execute(array(":id" => $reqId));
}

function ChangeRequestStatus(){
    global $reqId ,$pdo;
// Update status_id in the request table to 1
$updateRequestTabSql = "UPDATE request SET status_id = 1 WHERE req_id = :id";
$updateRequestTabStmt = $pdo->prepare($updateRequestTabSql);
$updateRequestTabStmt->execute(array(":id"=> $reqId));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    
        <?php  include_once "../student_affair/stud_affair_dash.php";  ?>
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

        <div class="report-container">
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
        foreach ($data as $row) {
            $timestamp = strtotime($row['req_date']);
            $formattedDate = date("d-m-Y", $timestamp);
            echo '<tr>';
            echo '<td style="text-align: center;"><a href="stud_affair_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['student_name']) . '</td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['serv_name']) . '</td>';
            echo '<td style="text-align: center;">' . $formattedDate . '</td>';
            echo '<td style="text-align: center;">' ;
            echo '<button type="button" class="btn btn-warning">'. htmlspecialchars($row['status']) . '</button></td>';
            echo '</tr>';
        }
        ?>
            

            </tbody>
        </table>
        <p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>
</body>
</html>