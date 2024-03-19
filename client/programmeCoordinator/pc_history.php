<?php
//!Include your database connection file
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();


if(!isset($_SESSION["pcid"])){  //*Redirect To Login
    header("Location: ../Login/staff_login.php");
}   
$stmt=$pdo->prepare("SELECT pc.pc_process_id ,r.req_id ,r.req_details ,r.req_date,pc.status_id,sv.serv_name,s.status,CONCAT(st.s_fname,' ',st.s_lname)AS FN ,st.s_pin 
from pc_process pc , request r ,service sv ,status s ,student st , cohort c where pc.req_id=r.req_id and pc.status_id=s.status_Id and r.serv_id=sv.serv_id and r.s_id =st.s_id and st.cohort_id = c.cohort_id and c.pc_id=:id and pc.status_id <> 5");
$stmt->execute(array(":id"=>$_SESSION["pcid"]));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["btnsubmit"])){
    $id=ValidateInput($_POST["id"]);
    

    $sql=" UPDATE  pc_process set pc_id=:pid where pc_process_id=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(
                            ':pid'=>$_SESSION["pcid"],
                            ':id'=>$id));
    header("Location: pcIndex.php");

}


function ValidateInput($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);

    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Programme Coordinator</title>
    
    
</head>
<body>

<?php include_once "../programmeCoordinator/pcDashboard.php"; ?>


<!-- 
<div class="box-container">
    
    <div class="box box1">
        <div class="text">
            <h2 class="topic-heading">10</h2>
            <h2 class="topic">Testimonial</h2>
        </div>

        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png">
    </div>

    <div class="box box2">
        <div class="text">
            <h2 class="topic-heading">15</h2>
            <h2 class="topic">Resumption</h2>
        </div>

        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185030/14.png">
    </div>

    <div class="box box3">
        <div class="text">
            <h2 class="topic-heading">8</h2>
            <h2 class="topic">Interruption</h2>
        </div>

        <img src=
            "https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(32).png"
            alt="comments">
    </div>

    <div class="box box4">
        <div class="text">
            <h2 class="topic-heading">3</h2>
            <h2 class="topic">Withdrawal</h2>
        </div>

        <img src=
            "https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
    </div>

    
</div>-->

    <div class="report-container" style="margin-top:125px;">
        <div class="report-header">
            <h1 class="recent-Articles"> Request History</h1>
            
        </div>

        

        <form method="POST" >
            <div id="popup" class="popup-container">
                <div class="popup-box">
                    <h1>Recommendation :</h1>
                    <input type="hidden" id="pc_process_id_input" name="id" >
                    <textarea class="popup-textarea" rows="4" placeholder="Enter your recommendation" name="recommendation" ></textarea>
                    <button class="popup-decline-button" type="submit" name="btnsubmit" onclick="closePopup()">Submit</button>
                    <button class="popup-decline-button" type="button" onclick="closePopup()">Cancel</button>
                </div>
            
        </form>
    </div>

        
        <table id="myTable" class="display">
            <thead>
                <tr class="header">
                    <th class="text-center" style="width:15%;" >Student ID</th>
                    <th class="text-center" style="width:20%;">Student Name</th>
                    <th class="text-center" style="width:15%;">Request Name</th>
                    <th  class="text-center" style="width:15%;">Date</th>
                    <th class="text-center" style="width:15%;">Status</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($data as $row) {
                    $dateString=$row['req_date'];
                    $timestamp = strtotime($dateString);
                    $formattedDate=date("d/m/Y",$timestamp);
                    echo '<tr>';
                    echo '<td class="text-center text-capitalize"><a href="pc_viewform.php?q=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_pin']) . '</a></td>';
                    echo '<td class="text-center text-capitalize">' . htmlspecialchars($row['FN']) . '</td>';
                    echo '<td class="text-center ">' . htmlspecialchars($row['serv_name']) . '</td>';
                    echo '<td class="text-center ">' .  $formattedDate . '</td>';
                    echo '<td class="text-center ">' ;
                    echo '<button class="btn btn-success">'.htmlspecialchars($row['status']) .'</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table> 
        
        <p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    
    <script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "paging": true, 
            "searching": true, 
            
        });
    });
</script>



</body>
</html>
