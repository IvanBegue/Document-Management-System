<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
require_once 'C:/xampp/htdocs/MiniProject/db/util.php';
session_start();
if(!isset( $_SESSION["hid"])){  //*Redirect To Login
  header("Location: ../Login/staff_login.php");
}  
$reqId = $_GET['req_id'];
$error="";

function getRegistryEmail($reqId){
  global $pdo;

  $sql=$pdo->prepare("SELECT r.r_umail from registry_process rp,registry r where r.r_id=rp.r_id AND rp.req_id=:rid");
  $sql->execute(array(":rid"=>$reqId));
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $registryEmail=$row["r_umail"];

  if($row){
    return $registryEmail;
  }else{
    error_log("Registry Email not found");

  }
}


function getregistryName($reqId){
  global $pdo;

  $sql=$pdo->prepare("SELECT  r.r_lname from registry_process rp,registry r where r.r_id=rp.r_id AND rp.req_id=:rid");
  $sql->execute(array(":rid"=>$reqId));
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $registryName=$row["r_lname"];

  if($row){
    return $registryName;
  }else{
    error_log("Registry Name not found");

  }
}

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
        INNER JOIN hos_process h on r.req_id = h.req_id
        INNER JOIN cohort c ON s.cohort_id = c.cohort_id
        INNER JOIN programme p ON c.prog_id = p.prog_id
        INNER JOIN school sc ON p.school_ID = sc.school_ID 
        INNER JOIN service se ON r.serv_id = se.serv_id
        WHERE h.req_id = :req_id";

$stmt = $pdo->prepare($sql);

$stmt->execute(array(":req_id"=>$reqId));

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
  
  header("location: ../hos/hos_dash.php");
}


if (isset($_POST["btnapprove"])) {
  
  try {
    $hid = $_SESSION["hid"];

    
    $pdo->beginTransaction();

    // Check if files were uploaded
    if (isset($_FILES['filecover'])&& $_FILES['filecover']['error'] === UPLOAD_ERR_OK) 
    {   
      $filename = $_FILES["filecover"]["name"];
      

      $uniqueFileName = uniqid('', true) . '_' . $filename;

        $dateProcess = date("Y-m-d");
        // Update the status_id in hos_process
        $updateRegistrySql = "UPDATE hos_process SET status_id = 1, hos_id = :hid, date_process = :date_process WHERE req_id = :id";
        $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
        $updateRegistryStmt->execute(array(":id" => $reqId, ":hid" => $hid, ":date_process" => $dateProcess));

        // Update the status_id in registry_process
        $updateRegistryProcessSql = "UPDATE registry_process SET status_id = 11 ,Form=:fn WHERE req_id = :id";
        $updateRegistryProcessStmt = $pdo->prepare($updateRegistryProcessSql);
        $updateRegistryProcessStmt->execute(array(":fn"=>$uniqueFileName,":id" => $reqId));

        // Update the status_id in request
        $updateRequestSql = "UPDATE request SET status_id = 11 WHERE req_id = :id";
        $updateRequestStmt = $pdo->prepare($updateRequestSql);
        $updateRequestStmt->execute(array(":id" => $reqId));

        if ($_FILES["filecover"]["error"] == UPLOAD_ERR_OK && $_FILES["filecover"]["size"] > 0) {
          move_uploaded_file($_FILES["filecover"]["tmp_name"], "C:/xampp/htdocs/MiniProject/FormProcess/" . $uniqueFileName);
        } else {
          error_log("File upload failed.");
        }

        $pdo->commit();
         //!Send Email Notification to registry
        $em=getregistryEmail($reqId);
        $sub="Document Management System Notification";
        $nm=getregistryName($reqId);
        $body="Dear $nm, a document is ready to proceed http://localhost/miniproject/client/Login/staff_login.php";

      sendEmail($em,$sub,$body,$nm);
        header("location: ../hos/hos_dash.php");
        exit();
    }else{

      $error="File Upload Mandatory";
      
    }

    
  } catch (Exception $e) {
    
      $pdo->rollBack();
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
    <link rel="stylesheet" href="../hos/hos_viewform.css" />
</head>
<body>

<!-- navbar -->
<nav class="navbar">
    <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <a href="../dissertation_commitee/hos_dash.php">
        <img src="images/UTM.png" alt="Description of the image"></i>
        </a>
    </div>
    

    <div class="search_bar">
        <input type="text" placeholder="Search">
    </div>

    <div class="navbar_content">
        <i class="bi bi-grid"></i>
        
        <i class='bx bx-bell'></i>
        
</nav>

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
        <form method="post" enctype="multipart/form-data">
          <div class="form-submit-btn">
            <div class="file-upload-container">
              <label for="filecover" class="form-label">Download Form & send to registry</label>
              <input class="form-control form-control" id="filecover" name="filecover" type="file" >
              <div id="selected-files" class="selected-files"></div>
            </div>
          </div>
          <div class="mt-5">
          <span class="fw-semibold text-danger ms-5">
          <?php 
            if(isset($error)){
                echo $error;
            }
            ?>
          </span>
            <button name="btnapprove" class="btn btn-primary col-12" type="submit">Send</button>
          </div>
          
        </form>
        
        

    </div>
    
      

<!-- sidebar -->
<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="../hos/hos_dash.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>

        <li class="item">
    <a href="../hos/hos_history.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-history"></i>
        </span>
        <span class="navlink">Request History</span>
    </a>
</li>
<li class="item">
    <a href="../hos/hos_pass.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-cog"></i>
        </span>
        <span class="navlink">Change Password</span>
    </a>
</li>
        
  <li class="item">
    <a href="../login/logout.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-exit"></i>
        </span>
        <span class="navlink">Log Out</span>
    </a>
</li>
 
        
    </ul>

    <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(hos_lname, ' ', hos_fname) AS FN FROM hos where  hos_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["hid"]));
            $rowFN=$stmtFN->fetch(PDO::FETCH_ASSOC);


        ?>
            
        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span><?php echo htmlspecialchars($rowFN["FN"])?></span>
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </nav>
    <script>
      document.getElementById('btnapprove').addEventListener('click', function() {
    if (confirm("Are you sure you want to approve this request?")) {
      // If the user confirms, submit the form with the 'btnreject' action
      document.querySelector('form').submit();
    }
  });
  document.getElementById('btnreject').addEventListener('click', function() {
    if (confirm("Are you sure you want to reject this request?")) {
      // If the user confirms, submit the form with the 'btnreject' action
      document.querySelector('form').submit();
    }
  });
</script>
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
<script src="script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
