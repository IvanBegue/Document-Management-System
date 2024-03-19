<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";

session_start();
$id=htmlspecialchars($_GET["q"]);

if(!isset($_SESSION["euid"])){  
  header("Location: ../Login/staff_login.php");
}   

if(isset($_POST["btnview"])|| isset($id)){
  try{
    
    $stmt=$pdo->prepare("SELECT CONCAT(s.s_lname,' ' ,s.s_fname) AS fn, s.s_umail,r.req_details, s.s_pin,s.s_mobile,s.s_address,c.cohort_name,p.prog_name,s.s_mode,sv.serv_name,r.req_date,sch.school_name ,s.year , s.semester FROM request r , student s,cohort c,programme p,service sv,school sch where r.s_id=s.s_id and s.cohort_id=c.cohort_id and c.prog_id=p.prog_id and r.serv_id=sv.serv_id and p.school_id=sch.school_id and r.req_id= :id");
    $stmt->execute(array(':id'=>$id));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

  }catch(exception $e){
    error_log('Error: ' . $e->getMessage());
  }


}
if(!$row){
  header("location: ../exam_unit/euIndex.php");
}

if (isset($_POST["btnsend"])) {
  try {
    
      $todayDate = date("Y-m-d");
      $filename = $_FILES["form"]["name"];
      
      $uniqueFileName = uniqid('', true) . '_' . $filename;
      // Update the pc_process table
      $sql = "UPDATE exam_unit_process SET  status_id = 4, date_process = :dt WHERE req_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array( ":id" => $id, ":dt" => $todayDate));

      

      //*Update status_id in registry_process to 11 (sent to pc)
      $updateRegistrySql = "UPDATE registry_process  SET status_id = 1 WHERE req_id = :id";
      $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
      $updateRegistryStmt->execute(array(":id" => $id));

      $updatestudent = "UPDATE request SET status_id = 6,Request_Forms= :fn WHERE req_id = :id";
      $updatestudent = $pdo->prepare($updatestudent);
      $updatestudent ->execute(array(":id" => $id,":fn" =>$uniqueFileName));
      //TODO Add a try..Catch here when hosted
      if ($_FILES["form"]["error"] == UPLOAD_ERR_OK && $_FILES["form"]["size"] > 0) {
        move_uploaded_file($_FILES["form"]["tmp_name"], "C:/xampp/htdocs/MiniProject/FormProcess/" . $uniqueFileName);
      } else {
        error_log("File upload failed.");
      }

      $email=$row["s_umail"];
      $sub="Notification";
      $by="Dear Student, Transcript ready to collect";
      $nm=$row["fn"];
      sendEmail($Studentemail,$sub,$by,$nm,$ccEmail,$ccName);
      
      header("location: ./euIndex.php");
      exit(); 
  } catch (Exception $e) {
      error_log('Error: ' . $e->getMessage());
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Student Request Form</title>
    <link rel="stylesheet" href="../programmeCoordinator/pc_dash.css" />
</head>
<body>


<?php include_once "../exam_unit/exam_dash.php"; ?>

<div class="container me-5 mt-5">
    <h1 class="form-title">Student Request Form</h1>

      <div class="mb-3">
        <label for="schoolname">School Name</label>
        <input type="text" value="<?php echo $row["school_name"]?>" class="form-control" id="schoolname"   style="font-weight: bold; color: #555;" readonly>
      </div>
      <div class="main-user-info">
        
        <div class="user-input-box">
          <label for="fullName">Full Name</label>
          <input type="text"   value="<?php echo $row["fn"] ?>" readonly/>
        </div>
        
      
      
        <div class="user-input-box">
          <label for="username">Student ID</label>
          <input type="text"     value="<?php echo $row["s_pin"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="email">Email Address</label>
          <input type="email"   value="<?php echo $row["s_umail"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="phoneNumber">Phone Number</label>
          <input type="text"   value="<?php echo $row["s_mobile"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="residentialAddress">Residential Address</label>
          <input type="text"   value="<?php echo $row["s_address"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="programme">Programme</label>
          <input type="text"   value="<?php echo $row["prog_name"] ?>" readonly/>
        </div>
        <div class="user-input-box">
            <label for="year">Year</label>
            <input type="text"  value="<?php echo $row["year"] ?>" readonly />
          </div>
      
      <div class="user-input-box">
        <label for="mode">Mode of Study</label>
        <input type="text"   value="<?php echo $row["s_mode"] ?>" readonly/>
      </div>
        

      
      <!-- Modify your request select element to include an onchange event -->
      <div class="user-input-box">
        <label for="request">Request</label>
        <input type="text"   value="<?php echo $row["serv_name"] ?>" readonly/>
      </div>
        
        

          <div class="user-input-box">
            <label for="cohort">Cohort</label>
            <input type="text"  value="<?php echo $row["cohort_name"] ?>" readonly />
          </div>
  
          <!-- Add a label for date with sysdate (current date) -->
          <div class="user-input-box">
            <label for="date">Date</label>
            <?php 
              $newDate=strtotime($row["req_date"] );


            ?>
            <input type="text"  value="<?php echo date('d/m/y',$newDate);?>" readonly/>
        </div>
        
  
          
        <div class="user-input-box">
            <label for="semester">Semester</label>
            <input type="text"  value="<?php echo $row["semester"] ?>" readonly/>
        
          </div>


        
      <div class="input-group">
        <label for="description" class="input-label">Detail of request</label>
        <textarea class="form-control" id="description" aria-label="With textarea"  readonly><?php echo($row["req_details"]) ?></textarea>
    </div>
    <?php
    $stmt2=$pdo->prepare("SELECT status_id from exam_unit_process  where req_id=:id");
    $stmt2->execute(array(":id"=>$id));
    $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
    
      if($row2["status_id"]==5){
        echo '<form  method="post" enctype="multipart/form-data">
            
        <div class="form-submit-btn">
            <label for="form" class="input-label">Upload Transcript</label>
            <input type="file"  name="form">
            <button  name="btnsend" class="btn btn-primary" type="submit" >Send</button>
        </div>
      </form>';
      }
    
    ?> 
    <div >
    <a class="btn btn-primary m-5" href="../exam_unit/euIndex.php">Back Home</a>
    </div> 
    
    
          
            
        
        

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
