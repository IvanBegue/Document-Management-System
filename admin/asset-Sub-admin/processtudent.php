<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php'; // !Load the database configuration file
require 'C:/xampp/htdocs/MiniProject/appfolder/vendor/autoload.php';
session_start();
if(!isset($_SESSION["id"])){
    header("location:adminlogin.php");
}

if(isset($_POST["btnsubmit"])){
    $uploadedFile = $_FILES["excelFile"]["tmp_name"];

     //* Load the Excel file
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();
    $isHeader = true; // Flag to skip the first row (header)
    $count=0;
    foreach($data as $row){
        if ($isHeader){
            $isHeader = false;
            continue;

        }
        $StartDateFormat=strtotime($row[6]);
        $NewStartDate=date('Y-m-d', $StartDateFormat); //TODO To fix bug with dates 

        $EndDateFormat=strtotime($row[7]);
        $NewEndDate=date('Y-m-d',  $EndDateFormat); //TODO To fix bug with dates 

        $dobDateFormat=strtotime($row[2]);
        $NewDob=date('Y-m-d',   $dobDateFormat); //TODO To fix bug with dates 

        $insert_data=array(':fname'=>$row[0],
                            ':ln'=>$row[1],
                            ':dob'=>$NewDob,
                            ':mail'=>$row[3],
                            ':add'=>$row[4],
                            ':pn'=>$row[5],
                            ':sdate'=>$NewStartDate,
                            ':edate'=>$NewEndDate,
                            ':pwd'=>$row[8],
                            ':mode'=>$row[9],
                            ':mobile'=>$row[10],
                            ':cht'=>$row[11]);
        
        $sql="INSERT INTO student (s_fname,s_lname,s_dob,s_umail,s_address,s_pin,s_start_date,s_end_date,s_password,s_mode,s_mobile,cohort_id )
                VALUES (:fname,:ln,:dob,:mail,:add,:pn,:sdate,:edate,:pwd,:mode,:mobile,:cht)";
        $stmt =$pdo->prepare($sql);
        $stmt->execute($insert_data);
        $count++;
    }
    $_SESSION["count"]=$count;
    error_log($count);
    header("location:addstudent.php");
}
?>

