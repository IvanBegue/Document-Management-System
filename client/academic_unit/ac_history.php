<?php
session_start();
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';

if (!isset($_SESSION['acid'])) {
    
    header('Location: ../Login/login.php'); 
    exit();
}

$sql = "SELECT 
ap.req_id,
s.s_id,
CONCAT(s.s_fname, ' ', s.s_lname) AS student_name, 
se.serv_name, 
st.status,
r.req_date,
s.s_pin,
ap.status_id
FROM ac_process ap
INNER JOIN request r ON ap.req_id = r.req_id
INNER JOIN student s ON r.s_id = s.s_id
INNER JOIN service se ON r.serv_id = se.serv_id
INNER JOIN status st ON ap.status_id = st.status_id
WHERE ap.status_id <> 5";

$stmt = $pdo->query($sql);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$serviceCounts = array();


foreach ($data as $row) {
    $servName = $row['serv_name'];
    

    if (array_key_exists($servName, $serviceCounts)) {

        $serviceCounts[$servName]++;
    } else {
    
        $serviceCounts[$servName] = 1;
    }
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
    <?php include_once "../academic_unit/ac_dash.php";?>
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
                            echo '<td style="text-align: center;"><a href="ac_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
                            echo '<td style="text-align: center;">' . htmlspecialchars($row['student_name']) . '</td>';
                            echo '<td style="text-align: center;">' . htmlspecialchars($row['serv_name']) . '</td>';
                            echo '<td style="text-align: center;">' .  $formattedDate . '</td>';
                            echo '<td style="text-align: center;">' ;
                            if($row["status_id"]==1){
                                echo '<button class="btn btn-success">'.htmlspecialchars($row['status']) .'</button>';
                            }else{
                                echo '<button class="btn btn-danger">'.htmlspecialchars($row['status']) .'</button>';
                            }   
                            
                            
                            echo '</td>';
                            
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table> 
                
                <p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>
</body>
</html>