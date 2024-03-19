<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();

$sql="SELECT r.req_id ,sv.serv_name , st.status, r.req_date,r.status_id,r.Request_Forms
FROM request r  ,service sv , status st 
WHERE r.serv_id=sv.serv_id and r.status_id=st.status_Id and r.s_id=:id ORDER BY r.req_date DESC";
$st=$pdo->prepare($sql);
$st->execute(array(":id"=>$_SESSION["sid"]));
$stStatus=$st->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document Management System</title>
</head>
<body>
<?php include_once "../student1/studentDash.php"; ?>


    <div class="report-container">
        <div class="report-header">
            <h1 class="recent-Articles">Request History</h1>
            
        </div>

        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Enter To Search">

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

        
        <table id="myTable">
            <tr class="header">
                
                <th style="width:15%;">Request Name</th>
                <th style="width:15%;">Date</th>
                <th style="width:10%;">Status</th>
                
            </tr>
            <?php $yellowStatus=array(2, 6, 5); ?>
            <?php
                foreach($stStatus as $row){
                    $dateString=$row["req_date"];
                    $timestamp = strtotime($dateString);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $documents = explode(',', $row["Request_Forms"]);
                    echo '<tr><td>';
                    echo $row["serv_name"];
                    echo "</td>";
                    echo '<td>';
                    echo  $formattedDate ;
                    echo "</td>";
                    if($row["status_id"]==6){
                        foreach ($documents as $doc) {
                            echo '<td>';
                            echo '<a class="btn btn-success col-5" href="download.php?file=' . urlencode($doc) . '">Download Form</a>';
                        }
                    }
                    if($row["status_id"]==2){
                        echo '<td>';
                        echo '<button type="button" class="btn btn-danger" >'.$row["status"].'</button>';
                    
                    }
                    if($row["status_id"]==5){
                        echo '<td>';
                        echo '<button type="button" class="btn btn-primary" >'.$row["status"].'</button>';
                    
                    }
                    if(!in_array($row["status_id"],$yellowStatus)){
                        echo '<td>';
                        echo '<button type="button" class="btn btn-warning">'.$row["status"].'</button>';
                    }
                    
                    echo "</td></tr>";
                }
            ?>
    </table>
    
</body>
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
</html>