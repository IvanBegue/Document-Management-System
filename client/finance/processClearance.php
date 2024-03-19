<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";

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

$todayDate=date("Y-m-d");
if (isset($_POST["btndel"])) {
    $id = validateInput($_POST["btndel"]);
    $pn=validateInput($_POST["pn"]);
    $recommendation= validateInput($_POST["recommendation"]);
    $updateSql ="UPDATE finance_process SET status_id = 17,Recommendation = :rcm, date_process = :dt, f_id=:fid WHERE req_id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute(array(":id"=>$id,":rcm"=>$recommendation,":dt" => $todayDate,":fid"=>$_SESSION['fid']));

      //*Update status_id in request table to decline
    $updateRequestSql = "UPDATE request SET status_id = 7 WHERE req_id = :id";
    $updateRequestStmt = $pdo->prepare($updateRequestSql);
    $updateRequestStmt->execute(array(":id" => $id));

    //*Update status_id in registry_process to clearance Denied
    $updateRegistrySql = "UPDATE registry_process SET status_id = 7 WHERE req_id = :id";
    $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
    $updateRegistryStmt->execute(array(":id" => $id));

    $email=getStudentEmail($pn);
    $nm="";
    $sub="UTM Document Management System Notification";
    $by="Dear student , your request cannot be proceed as you have non-financial clearance.Please contact the finance department of UTM for more information";
    sendEmail($email,$sub,$by,$nm);
    
    

}

header("location:../finance/financeindex.php");




?>
