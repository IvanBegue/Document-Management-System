<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
require_once 'C:/xampp/htdocs/MiniProject/db/util.php';
$id = htmlspecialchars($_POST["id"]);

    $sql=$pdo->prepare("SELECT s.s_umail ,s.s_lname from student s , request r where r.s_id= s.s_id and r.req_id=:id");
    $stmt->execute(array(":id"=>$id));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $studentEmail=$row["s_umail"];
    $studentName=$row["s_lname"];
    


if(isset($_POST["btnsubmit"])){
    

    
    
    //*Sent Status To ready To Collect in table registry process
    $sql1="UPDATE registry_process set status_id=4 where req_id = :id";
    $stmt1=$pdo->prepare($sql1);
    $stmt1->execute(array(':id'=>$id));

    //*Sent Status To Ready To collect in table request
    $sql2="UPDATE request set status_id=6 where req_id = :id";
    $stmt2=$pdo->prepare($sql2);
    $stmt2->execute(array(':id'=>$id));
    $sub="Document Management System Notification";
    $body="Your forms is ready to collect";
    sendEmail($studentEmail,$sub,$body,$studentName);

}

if(isset($_POST["btndenied"])){

    
    //*Sent Status To Denied  in table registry process
    $sql1="UPDATE registry_process set status_id=2 where req_id = :id";
    $stmt1=$pdo->prepare($sql1);
    $stmt1->execute(array(':id'=>$id));

    //*Sent Status To Ready To collect in table request
    $sql2="UPDATE request set status_id=2 where req_id = :id";
    $stmt2=$pdo->prepare($sql2);
    $stmt2->execute(array(':id'=>$id));
    
    $sub="Document Management System Notification";
    $body="Your request has been declined";
    sendEmail($studentEmail,$sub,$body,$studentName);
}
header('location: RegistryIndex.php');
?>