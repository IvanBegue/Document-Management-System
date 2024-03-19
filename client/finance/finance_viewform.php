<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";

if (!isset($_SESSION['fid'])) {
  
  header('Location: ../login/staff_login.php'); 
  
}

$reqId = $_GET['req_id'];
$todayDate=date("Y-m-d");
$sql = "SELECT
        CONCAT(s.s_fname, ' ', s.s_lname) AS full_name,
        s.s_pin AS student_id,
        s.s_umail AS email,
        s.s_mobile AS phone_number,
        s.s_address AS residential_address,
        p.prog_name AS programme_name,
        sc.school_name AS school_name,  
        s.year AS year,
        s.s_mode AS mode,
        se.serv_name AS request, 
        c.cohort_name AS cohort_name,
        r.req_date AS request_date,
        s.semester AS semester,
        r.req_details AS request_detail,
        r.serv_id 
        FROM student s
        INNER JOIN request r ON s.s_id = r.s_id
        INNER JOIN cohort c ON s.cohort_id = c.cohort_id
        INNER JOIN programme p ON c.prog_id = p.prog_id
        INNER JOIN school sc ON p.school_ID = sc.school_ID 
        INNER JOIN service se ON r.serv_id = se.serv_id
        WHERE r.req_id = :req_id";


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':req_id', $reqId);
$stmt->execute();

// Fetch the data
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was found
if ($row) {
  $fullName = $row['full_name'];
  $studentId = $row['student_id'];
  $email = $row['email'];
  $phoneNumber = $row['phone_number'];
  $residentialAddress = $row['residential_address'];
  $programmeName = $row['programme_name'];
  $schoolName = $row['school_name']; 
  $year = $row['year'];
  $mode = $row['mode'];
  $request =  $row['request'];
  $cohortName = $row['cohort_name'];
  $requestDate = $row['request_date'];
  $semester = $row['semester'];
  $requestDetail = $row['request_detail'];
  $servid =$row['serv_id'];

} else {

  header("location: ../finance/financeindex.php");


}

function getPcEmail($studentId){
  global $pdo;
  $sid=$studentId;
  $sql=$pdo->prepare("SELECT pc.pc_umail FROM student s ,cohort c,program_coordinator pc where s.cohort_id =c.cohort_id AND c.pc_id = pc.pc_id AND s.s_pin=:sid");
  $sql->execute(array(":sid"=>$sid));
  $row=$sql->fetch(PDO::FETCH_ASSOC);
  $email=$row["pc_umail"];

  if($row){
    return $email;
  } else{
    error_log("ERROR PC Email NOT FOUND");
  }
}

function getPcName($studentId){
  global $pdo;
  $sid=$studentId;
  $sql=$pdo->prepare("SELECT pc.pc_fname FROM student s ,cohort c,program_coordinator pc where s.cohort_id =c.cohort_id AND c.pc_id = pc.pc_id AND s.s_pin=:sid");
  $sql->execute(array(":sid"=>$sid));
  $row=$sql->fetch(PDO::FETCH_ASSOC);
  $name=$row["pc_fname"];

  if($row){
    return $name;
  } else{
    error_log("ERROR PC NAME NOT FOUND");
  }
}
function getPCID($studentId){
  global $pdo;
  $sid=$studentId;
  $sql=$pdo->prepare("SELECT pc.pc_id FROM student s ,cohort c,program_coordinator pc where s.cohort_id =c.cohort_id AND c.pc_id = pc.pc_id AND s.s_pin=:sid");
  $sql->execute(array(":sid"=>$sid));
  $row=$sql->fetch(PDO::FETCH_ASSOC);
  $id=$row["pc_id"];

  if($row){
    return $id;
  } else{
    error_log("ERROR PC ID NOT FOUND");
  }
}

function getDCEmail(){
  global $pdo;
  $sql=$pdo->query("SELECT dc_umail FROM disertation_commitee");
  $sql->execute();
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $DCemail=$row["dc_umail"];
  if($row){
    return $DCemail;
  }else{
    error_log("ERROR DC EMAIL NOT FOUND");
  }
  
}
function getACEmail(){
  global $pdo;
  $sql=$pdo->query("SELECT acu_umail FROM academic_unit");
  $sql->execute();
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $AcEmail=$row["acu_umail"];

  if($row){
    return $AcEmail;
  }else{
    error_log("ERROR ACADEMIC UNIT EMAIL NOT FOUND");

  }

}

function getExamUnitEmail(){
  global $pdo;
  $sql=$pdo->query("SELECT eu_umail FROM exam_unit");
  $sql->execute();
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $EuEmail=$row["eu_umail"];

  if($row){
    return $EuEmail;
  }else{
    error_log("ERROR EXAM UNIT EMAIL NOT FOUND");
  }
    
}
function getStatus($reqId){
  global $pdo;
  $ispending=false;
  $sql=$pdo->prepare("SELECT status_id from finance_process where req_id=:id");
  $sql->execute(array(":id"=>$reqId));
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  if($row["status_id"]==5 || $row["status_id"]==17){
    $ispending=True;
  }

  return $ispending;
}

if (isset($_POST["save"])) {

$checkRcSql = "SELECT rp.status_id, r.serv_id FROM rc_process rp
              INNER JOIN request r ON rp.req_id = r.req_id
              WHERE rp.req_id = :id"; //! Check if status_id in rc_process is 8
$checkRcStmt = $pdo->prepare($checkRcSql);
$checkRcStmt->execute(array(":id"=>$reqId));
$rcData = $checkRcStmt->fetch(PDO::FETCH_ASSOC);

if($servid==9){//*check if service refund of fees
  $sql = "UPDATE finance_process SET  status_id = 1, date_process = :dt, f_id=:fid WHERE req_id = :id";
  $stmt1 = $pdo->prepare($sql);
  $stmt1->execute(array( ":dt" => $todayDate,":fid"=>$_SESSION['fid'],":id" => $reqId));

  //*Update status_id in registry_process to Approved
  $updateRegistrySql = "UPDATE registry_process SET status_id = 1 WHERE req_id = :id";
  $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
  $updateRegistryStmt->execute(array(":id" => $reqId));

  //*Update status_id in request table to Approved
  $updateRequestSql = "UPDATE request SET status_id = 1 WHERE req_id = :id";
  $updateRequestStmt = $pdo->prepare($updateRequestSql);
  $updateRequestStmt->execute(array(":id" => $reqId));

  $Studentemail=$email;
  $nm="";
  $sub="UTM Document Management System Notification";
  $by="Dear student, your refund has been approved  by the finance department of UTM";
  sendEmail($email,$sub,$by,$nm);


}else{
  $sql ="UPDATE finance_process SET  status_id = 8, date_process = :dt , f_id=:fid WHERE req_id = :id";
  $stmt1 = $pdo->prepare($sql);
  $stmt1->execute(array( ":dt" => $todayDate, ":fid"=>$_SESSION['fid'],":id" => $reqId));

}



if ($rcData['status_id'] == 8) {

    // Add to the relevant process table based on serv_id (if needed)
    switch ($rcData['serv_id']) {
        case 1:
        case 4:
        case 5:
        case 6:
        case 7:
            $pcid=getPCID($studentId);
            // Add to pc_process table
            $insertPcProcessSql = "INSERT INTO pc_process (pc_id ,req_id) VALUES (:pcid,:id)";
            $insertPcProcessStmt = $pdo->prepare($insertPcProcessSql);
            $insertPcProcessStmt->execute(array(":pcid"=>$pcid ,":id" => $reqId));
            
            //*Update status_id in registry_process to SENT TO PC
            $updateRegistrySql = "UPDATE registry_process SET status_id = 10 WHERE req_id = :id";
            $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
            $updateRegistryStmt->execute(array(":id" => $reqId));
            
            //*Update status_id in request table to SENT TO PC
            $updateRequestSql = "UPDATE request SET status_id = 10 WHERE req_id = :id";
            $updateRequestStmt = $pdo->prepare($updateRequestSql);
            $updateRequestStmt->execute(array(":id" => $reqId));
            

            //*SENDING  PC EMAIL After Clearance Approved
            $email=getPcEmail($studentId);
            $nm=getPcName($studentId);
            $sub="UTM Document Management System Notification";
            $by="Dear .$nm. ,you just received a new request to handle http://localhost/miniproject/client/Login/staff_login.php";

            sendEmail($email,$sub,$by,$nm);
            break;

        case 2:
            // Add to exam_unit table
            $insertExamUnitSql = "INSERT INTO exam_unit_process (req_id) VALUES (:id)";
            $insertExamUnitStmt = $pdo->prepare($insertExamUnitSql);
            $insertExamUnitStmt->execute(array(":id" => $reqId));

             //*Update status_id in registry_process to SENT TO EXAM UNIT
              $updateRegistrySql = "UPDATE registry_process SET status_id = 12 WHERE req_id = :id";
              $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
              $updateRegistryStmt->execute(array(":id" => $reqId));

             //*Update status_id in request table to SENT TO EXAM UNIT
              $updateRequestSql = "UPDATE request SET status_id = 12 WHERE req_id = :id";
              $updateRequestStmt = $pdo->prepare($updateRequestSql);
              $updateRequestStmt->execute(array(":id" => $reqId));

            //*SENDING EMAIL TO EXAM UNIT
            $email=getExamUnitEmail();
            $nm="";
            $sub="UTM Document Mangement System Notification";
            $by="Dear Sir/Madam , you just received a new request to handle http://localhost/miniproject/client/Login/staff_login.php";
            foreach($email as $emails){
              sendEmail($email,$sub,$by,$nm);
            }
            
            break;

        case 3:
            // Add to academic_unit table
            $insertAcademicUnitSql = "INSERT INTO ac_process (req_id) VALUES (:id)";
            $insertAcademicUnitStmt = $pdo->prepare($insertAcademicUnitSql);
            $insertAcademicUnitStmt->execute(array(":id" => $reqId));

            
             //*Update status_id in registry_process to SENT TO Academic UNIT
              $updateRegistrySql = "UPDATE registry_process SET status_id = 15 WHERE req_id = :id";
              $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
              $updateRegistryStmt->execute(array(":id" => $reqId));

             //*Update status_id in request table to SENT TO Academic UNIT
              $updateRequestSql = "UPDATE request SET status_id = 15 WHERE req_id = :id";
              $updateRequestStmt = $pdo->prepare($updateRequestSql);
              $updateRequestStmt->execute(array(":id" => $reqId));

            //*SENDING EMAIL TO ACADEMIC UNIT
            $email=getACEmail();
            $nm="";
            $sub="UTM Document Manegement System Notification";
            $by="Dear Sir/Madam , you just received a new request to handle http://localhost/miniproject/client/Login/staff_login.php";
            foreach($email as $emails){
              sendEmail($email,$sub,$by,$nm);
            }
            
            break;

        case 8:
            // Add to dissertation_commitee table
            $insertDissertationSql = "INSERT INTO dc_process (req_id) VALUES (:id)";
            $insertDissertationStmt = $pdo->prepare($insertDissertationSql);
            $insertDissertationStmt->execute(array(":id" => $reqId));

            //*Update status_id in registry_process to SENT TO Dissertation Committee
            $updateRegistrySql = "UPDATE registry_process SET status_id = 16 WHERE req_id = :id";
            $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
            $updateRegistryStmt->execute(array(":id" => $reqId));

           //*Update status_id in request table to SENT TO Dissertation CommitteeT
            $updateRequestSql = "UPDATE request SET status_id = 16 WHERE req_id = :id";
            $updateRequestStmt = $pdo->prepare($updateRequestSql);
            $updateRequestStmt->execute(array(":id" => $reqId));
            //*SENDING EMAIL TO DISSERTATION COMMITEE
            $email=getDCEmail();
            $nm="";
            $sub="UTM Document Manegement System Notification";
            $by="Dear Sir/Madam , you just received a new request to handle http://localhost/miniproject/client/Login/staff_login.php";
            foreach($email as $emails){
              sendEmail($email,$sub,$by,$nm);
            }
            break;

          
    }
}

header("location: ../finance/financeindex.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>Student Request Form</title>
  
</head>

<body>

<?php include_once "../finance/finance_dash.php" ?>
  <div class="container">
    <h1 class="form-title">Student Request Form</h1>
   
      <div class="mb-3">
        <label for="schoolname">School Name</label>
        <input type="text" class="form-control" id="schoolname" value="<?php echo $schoolName; ?>" readonly style="font-weight: bold; color: #555;">
      </div>
      <div class="main-user-info">

        <div class="user-input-box">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" name="fullName" value="<?php echo $fullName; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="username">Student ID</label>
          <input type="text" id="username" name="username" value="<?php echo $studentId; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="phoneNumber">Phone Number</label>
          <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="residentialAddress">Residential Address</label>
          <input type="text" id="residentialAddress" name="residentialAddress" value="<?php echo $residentialAddress; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="programme">Programme</label>
          <input type="text" id="programme" name="programme" value="<?php echo $programmeName; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="year">Year</label>
          <input type="text" id="year" name="year" value="<?php echo $year; ?>" readonly />
        </div>

        <div class="user-input-box">
          <label for="mode">Mode of Study</label>
          <input type="text" id="mode" name="mode" value="<?php echo $mode; ?>" readonly />
        </div>



        <!-- Modify your request select element to include an onchange event -->
        <div class="user-input-box">
          <label for="request">Request</label>
          <input type="text" id="request" name="request" value="<?php echo $request; ?>" readonly  />
        </div>



        <div class="user-input-box">
          <label for="cohort">Cohort</label>
          <input type="text" id="cohort" name="cohort" value="<?php echo $cohortName; ?>" readonly />
        </div>

        <!-- Add a label for date with sysdate (current date) -->
        <div class="user-input-box">
          <label for="date">Date</label>
          <input type="text" id="date" name="date" value="<?php echo $requestDate; ?>" readonly />
        </div>



        <div class="user-input-box">
          <label for="semester">Semester</label>
          <input type="text" id="semester" name="semester" value="<?php echo $semester; ?>" readonly />
        </div>



        <div class="input-group">
          <label for="description" class="input-label">Detail of request</label>
          <textarea class="form-control" id="description" aria-label="With textarea" readonly>
                    <?php echo $requestDetail; ?>
                </textarea>
        </div>

      
        <?php 
        $ispending=getStatus($reqId);

        if($ispending)
        {
          echo '<div class="row g-3">';
            echo '<div class="col">';
              echo '<form method="post">';
                echo '<div class="form-submit-btn">
                        <button type="submit" name="save" class="col-12 btn btn-success btn-lg">Approve</button>
                          </div>';
                  echo '</form>';
                    echo '</div>';
                      echo '<div class="col">
                            <button class="btn btn-danger btn-lg" name="btndel" data-bs-toggle="modal" data-bs-target="#exampleModal">Decline</button>
                            </div>';
                        
                          echo '</div>';
        }
        ?>
          
      
          <a href="../finance/financeindex.php"class="btn btn-primary btn-lg">Back Home</a>

<!--MODAL start Here -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="exampleModalLabel">Add Recommendation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action=processClearance.php>
          
          <div class="mb-3"> 
            <label for="message-text " class="col-form-label text-dark">Recommendation</label>
            <textarea class="form-control" id="message-text" name="recommendation"></textarea>
          </div>
          <?php echo '<input type="hidden" name="pn" value="'. $studentId .'">'; ?>
          <?php echo '<input type="hidden"  name="btndel" value="'. $reqId.'">'; ?>
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!--MODAL end here-->
        
        
        


        

    


  
</body>

</html>