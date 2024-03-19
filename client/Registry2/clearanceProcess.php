<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
session_start();

if(isset($_POST["btnclr"])){
    $id=htmlspecialchars($_POST["btnclr"]);

    $sqldate=$pdo->prepare('SELECT req_date , serv_id from request where req_id=:rid');
    $sqldate ->execute(array(':rid'=>$id));
    $rowrequest=$sqldate->fetch(PDO::FETCH_ASSOC);


    if($rowrequest["serv_id"] >= 1 && $rowrequest["serv_id"] <= 8){
        //*REQUESTING CLERANCE
        $sql="INSERT INTO rc_process (req_id) values (:id)";
        $stmt=$pdo->prepare($sql);
        $stmt ->execute(array(':id'=>$id));

        $sql1="INSERT INTO finance_process (req_id) values (:id)";
        $stmt1=$pdo->prepare($sql1);
        $stmt1 ->execute(array(':id'=>$id));

            //*Set Status to clearance Monitoring for student and request
            $sql4="INSERT INTO registry_process (r_id,date_process,status_id,req_id) values (:id,:dt,:st,:rid)";
            $stmt4=$pdo->prepare($sql4);
            $stmt4 ->execute(array(':id'=>$_SESSION["rid"],':dt'=>$rowrequest["req_date"],':st'=>9,':rid'=>$id));

            $sql3="UPDATE  request SET status_id =9 where req_id=:id";
            $st1=$pdo->prepare($sql3);
            $st1->execute(array(':id'=>$id));
    }
    
    if($rowrequest["serv_id"]==9){
        //*REQUESTING CLERANCE FOR FINANCE IF REQUEST IS REFUND OF FEES
        $sql1="INSERT INTO finance_process (req_id) values (:id)";
        $stmt1=$pdo->prepare($sql1);
        $stmt1 ->execute(array(':id'=>$id));

        //*Set Status to clearance Monitoring for student and request
        $sql4="INSERT INTO registry_process (r_id,date_process,status_id,req_id) values (:id,:dt,:st,:rid)";
        $stmt4=$pdo->prepare($sql4);
        $stmt4 ->execute(array(':id'=>$_SESSION["rid"],':dt'=>$rowrequest["req_date"],':st'=>9,':rid'=>$id));

        $sql3="UPDATE  request SET status_id =9 where req_id=:id";
        $st1=$pdo->prepare($sql3);
        $st1->execute(array(':id'=>$id));
    }
    if($rowrequest["serv_id"]==12){
        //*REQUESTING CHANGING DETAILS
        $sql1="INSERT INTO student_affairs_process (req_id) values (:rid)";
        $stmt1=$pdo->prepare($sql1);
        $stmt1 ->execute(array(':rid'=>$id));

         //*Set Status to Sent to student Affairs in request and registry_process table
        $sql4="INSERT INTO registry_process (r_id,date_process,status_id,req_id) values (:id,:dt,:st,:rid)";
        $stmt4=$pdo->prepare($sql4);
        $stmt4 ->execute(array(':id'=>$_SESSION["rid"],':dt'=>$rowrequest["req_date"],':st'=>13,':rid'=>$id));
        
        $sql3="UPDATE  request SET status_id =13 where req_id=:id";
        $st1=$pdo->prepare($sql3);
        $st1->execute(array(':id'=>$id));
    }

    
    
    header('location: ../Registry2/RegistryIndex.php');
}

?>