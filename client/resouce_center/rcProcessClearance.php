<?php
session_start();
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
require_once 'C:/xampp/htdocs/MiniProject/db/util.php';

function validateInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}
function getStudentEmail($pn){
    global $pdo;

    $sql=$pdo->prepare("SELECT s_umail FROM student WHERE s_pin=:pn");
    $sql->execute(array(":pn"=>$pn));
    $row=$sql->fetch(PDO::FETCH_ASSOC);
    $studentEmail=$row["s_umail"];

    if($row){
        return $studentEmail;
    }else{
        error_log("ERROR STUDENT EMAIL NOT FOUND");

    }

}


if (isset($_POST["btndel"])) {
    $id = validateInput($_POST["btndel"]);
    $pn=validateInput($_POST["pn"]);
    $recommendation=validateInput($_POST["recommendation"]);
    
    $updateSql ="UPDATE  rc_process SET status_id = 17, 	Recommendation=:rcm , rc_id=:rcid WHERE req_id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute(array(":id"=>$id,":rcm"=>$recommendation, ":rcid"=>$_SESSION['rcid']));

      //*Update status_id in request table to decline
    $updateRequestSql = "UPDATE request SET status_id = 2 WHERE req_id = :id";
    $updateRequestStmt = $pdo->prepare($updateRequestSql);
    $updateRequestStmt->execute(array(":id" => $id));

    //*Update status_id in registry_process to clearance Denied
    $updateRegistrySql = "UPDATE registry_process SET status_id = 7 WHERE req_id = :id";
    $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
    $updateRegistryStmt->execute(array(":id" => $id));

    $email=getStudentEmail($pn);
    $nm="";
    $sub="UTM Document Management System Notification";
    $by="Dear student , your request cannot be proceed as the resource center has denied your  clearance.Please contact the resource center department of UTM for more information";
    sendEmail($email,$sub,$by,$nm);
    
    

}

header("location: ../resouce_center/rc_dash.php");




?>
