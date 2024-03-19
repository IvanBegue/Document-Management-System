<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
if (!isset($_SESSION['said'])) {
    
  header('Location: ../login/login.php'); 
  
}

$reqId = $_GET['req_id'];

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
        r.req_details AS request_detail
        FROM student s
        INNER JOIN request r ON s.s_id = r.s_id
        INNER JOIN student_affairs_process sap ON sap.req_id=r.req_id
        INNER JOIN cohort c ON s.cohort_id = c.cohort_id
        INNER JOIN programme p ON c.prog_id = p.prog_id
        INNER JOIN school sc ON p.school_ID = sc.school_ID 
        INNER JOIN service se ON r.serv_id = se.serv_id
        WHERE sap.req_id = :req_id";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':req_id', $reqId);
        $stmt->execute();
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
} else {
  
  header("location: ../student_affair/saindex.php");


}


if (isset($_POST["btnapprove"])) {
  try {
      $dateProcess = date("Y-m-d");
      // Update the status_id in stude
      $updateRegistrySql = "UPDATE student_affairs_process SET status_id = 1, 	sa_id = :said, date_process = :date_process WHERE req_id = :id";
      $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
      $updateRegistryStmt->execute(array(":id" => $reqId, ":said" => $_SESSION['said'], ":date_process" => $dateProcess));

      // Update the status_id in registry_process
      $updateRegistryProcessSql = "UPDATE registry_process SET status_id = 1 WHERE req_id = :id";
      $updateRegistryProcessStmt = $pdo->prepare($updateRegistryProcessSql);
      $updateRegistryProcessStmt->execute(array(":id" => $reqId));

      // Update the status_id in request
      $updateRequestSql = "UPDATE request SET status_id = 1 WHERE req_id = :id";
      $updateRequestStmt = $pdo->prepare($updateRequestSql);
      $updateRequestStmt->execute(array(":id" => $reqId));
      //!SENDING TO STUDENT AFTER PROCESSING REQUEST
      $Studentemail=$email;
      $sub="UTM Document Management System Notification";
      $by="Dear Student, your request to change your personal detail has been approved.<br> You are required to bring a proof of address to the Student Affairs.";
      $nm=$fullName;
      sendEmail($Studentemail,$sub,$by,$nm,$ccEmail,$ccName);
      header("location: ../student_affair/saindex.php");
    
  } catch (Exception $e) {
    // Handle any exceptions that may occur during the database operations
    //!$pdo->rollBack();
    
    error_log('Error: ' . $e->getMessage());
    header("location: ../student_affair/saindex.php");
  }

}


if (isset($_POST["btnreject"])) {
  
  try {
    
    $dateProcess = date("Y-m-d");
      // Update the status_id in dc_process
      $updateRegistrySql = "UPDATE dc_process SET status_id = 2, sa_id = :said, date_process = :date_process WHERE req_id = :id";
      $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
      $updateRegistryStmt->execute(array(":id" => $reqId, ":said" => $_SESSION['said'], ":date_process" => $dateProcess));

    // Update the status_id in registry_process
    $updateRegistry1ProcessSql = "UPDATE registry_process SET status_id = 2 WHERE req_id = :id";
    $updateRegistry1ProcessStmt = $pdo->prepare($updateRegistry1ProcessSql);
    $updateRegistry1ProcessStmt->execute(array(":id" => $reqId));

    // Update the status_id in request
    $updateRequest1Sql = "UPDATE request SET status_id = 2 WHERE req_id = :id";
    $updateRequest1Stmt = $pdo->prepare($updateRequest1Sql);
    $updateRequest1Stmt->execute(array(":id" => $reqId));

    //!$pdo->commit();

    //!SENDING TO STUDENT AFTER PROCESSING REQUEST
    $Studentemail=$email;
    $sub="UTM Document Management System Notification";
    $by="Dear Student, your request has been rejected by the dissertation committee";
    $nm=$fullName;
    sendEmail($Studentemail,$sub,$by,$nm,$ccEmail,$ccName);
    header("location: ../student_affair/saindex.php");
    

  } catch (Exception $e) {
    // Handle any exceptions that may occur during the database operations
    //!$pdo->rollBack();
    // Handle any errors that may occur
    error_log('Error: ' . $e->getMessage());
    header("location: ../student_affair/saindex.php");
  }
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

<?php  include_once "../student_affair/stud_affair_dash.php";  ?>

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
        //!add req_id
        $sql2=$pdo->prepare("SELECT status_id from student_affairs_process where req_id =:id");
        $sql2->execute(array(":id"=>$reqId));
        $rowStatus=$sql2->fetch(PDO::FETCH_ASSOC);

        if($rowStatus["status_id"]==5)
        {
          echo '<form method="post">
          <div class="form-submit-btn">
            <button name="btnapprove" class="btn btn-primary" type="submit">Approve</button>
            <button name="btnreject" class="btn btn-danger" type="submit">Reject</button>
          </div>
        </form>';
        }
        ?>
        <a class="btn btn-primary" href="./saindex.php">Back Home</a>
    </div>
    

</body>
</html>
