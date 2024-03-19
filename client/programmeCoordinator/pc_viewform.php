<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
session_start();
$id=$_GET["q"];

if(!isset($_SESSION["pcid"])){  
  header("Location: ../Login/staff_login.php");
}   
$pcid=$_SESSION["pcid"];


function getregistryEmail($id){
  global $pdo;

  $sql=$pdo->prepare("SELECT r.r_umail from registry_process rp,registry r where r.r_id=rp.r_id AND rp.req_id=:rid");
  $sql->execute(array(":rid"=>$id));
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $registryEmail=$row["r_umail"];

  if($row){
    return $registryEmail;
  }else{
    error_log("Registry Email not found");

  }
}
function getregistryName($id){
  global $pdo;

  $sql=$pdo->prepare("SELECT  r.r_lname from registry_process rp,registry r where r.r_id=rp.r_id AND rp.req_id=:rid");
  $sql->execute(array(":rid"=>$id));
  $row=$sql->fetch(PDO::FETCH_ASSOC);

  $registryName=$row["r_lname"];

  if($row){
    return $registryName;
  }else{
    error_log("Registry Name not found");

  }
}


function getHOSEmail($pcid){
  global $pdo;
  $sql=$pdo->prepare("SELECT  h.hos_umail from hos h , program_coordinator pc where pc.Hos_id =h.hos_id  AND pc.pc_id=:id");
  $sql->execute(array(':id'=>$pcid));
  $EmRow=$sql->fetch(PDO::FETCH_ASSOC);
  $HosEmail=$EmRow["hos_umail"];
  return $HosEmail;

}

function getHOSID($pcid){
  global $pdo;
  $sql=$pdo->prepare("SELECT  hos_id from  program_coordinator  where  pc_id=:id");
  $sql->execute(array(':id'=>$pcid));
  $IDRow=$sql->fetch(PDO::FETCH_ASSOC);
  $HosID=$IDRow["hos_id"];
  return $HosID;

}


if(isset($id)){
  try{
    
    $stmt=$pdo->prepare("SELECT CONCAT(s.s_lname,' ' ,s.s_fname) AS fn, r.serv_id,s.s_umail,r.req_details, s.s_pin,s.s_mobile,s.s_address,c.cohort_name,p.prog_name,s.s_mode,sv.serv_name,r.req_date,sch.school_name ,s.year , s.semester,pc.status_id ,pc.Recommendation FROM request r , student s,cohort c,programme p,service sv,school sch ,pc_process pc where r.s_id=s.s_id and s.cohort_id=c.cohort_id and c.prog_id=p.prog_id and r.serv_id=sv.serv_id and p.school_id=sch.school_id and pc.req_id=r.req_id and pc.req_id=:id");
    $stmt->execute(array(':id'=>$id));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

  }catch(exception $e){
    error_log('Error: ' . $e->getMessage());
    header("location: ../programmeCoordinator/pcIndex.php");
  }
}
  if(!$row){
    header("location: ../programmeCoordinator/pcIndex.php");
    
  }
  
if (isset($_POST["btnsend"])) {
  try {
      $todayDate = date("Y-m-d");

     
      $recommendation=validate_input($_POST["recommendation"]);

      
      // Update the pc_process table
      $sql = "UPDATE pc_process SET  status_id = 1, Recommendation=:recm ,process_date = :dt WHERE req_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array( ":id" => $id, ":recm"=>$recommendation,":dt" => $todayDate));

     

      if($row["serv_id"] >= 4 && $row["serv_id"] <=7){ //*Sending to HOS Process
        $HosId=getHOSID($pcid);
        $sqlHos="INSERT INTO hos_process (hos_id,req_id) values(:hid,:rid)";
        $stmtHos=$pdo->prepare($sqlHos);
        $stmtHos->execute(array(':hid'=>$HosId,':rid'=>$id));

        $updateRegistrySql = "UPDATE registry_process SET status_id = 14 WHERE req_id = :id";
        $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
        $updateRegistryStmt->execute(array(":id" => $id));

        $updatestudent = "UPDATE request SET status_id = 14 WHERE req_id = :id";
        $updatestudent = $pdo->prepare($updatestudent);
        $updatestudent ->execute(array(":id" => $id));

        $em=getHOSEmail($pcid);
        $sub="Document Management System Notification";
        $body="You got a new request to handle";
        $nm=" ";
      
        
        sendEmail($em, $sub, $body, $nm, $ccEmail, $ccName);


      }

      if($row["serv_id"]==1){ //* Sending to registry
          // Update status_id in registry_process and student to 11 (ready to proceed)
          $filename = $_FILES["form"]["name"];
          $uniqueFileName = uniqid('', true) . '_' . $filename;
    
          if ($_FILES["form"]["error"] == UPLOAD_ERR_OK && $_FILES["form"]["size"] > 0) {
              move_uploaded_file($_FILES["form"]["tmp_name"], "../MiniProject/FormProcess/" . $uniqueFileName);
          } else {
              error_log("File upload failed.");
          }
      $updateRegistrySql = "UPDATE registry_process SET status_id = 11 ,Form = :fn WHERE req_id = :id";
      $updateRegistryStmt = $pdo->prepare($updateRegistrySql);
      $updateRegistryStmt->execute(array(":id" => $id,":fn" =>$uniqueFileName));


      $updatestudent = "UPDATE request SET status_id = 11 WHERE req_id = :id";
      $updatestudent = $pdo->prepare($updatestudent);
      $updatestudent ->execute(array(":id" => $id));

      //!Send Email Notification to registry
      $em=getregistryEmail($id);
      $sub="Document Management System Notification";
      $nm=getregistryName($id);
      $body="Dear $nm, a document is ready to proceed http://localhost/miniproject/client/Login/staff_login.php";

      $ccEmail="ivansbegue@live.com";//!Need to change to correct group
      $ccName="Site Registry";
      sendEmail($em, $sub, $body, $nm, $ccEmail, $ccName);

      }

      header("location: ../programmeCoordinator/pcIndex.php");
      
  } catch (Exception $e) {
      error_log('Error: ' . $e->getMessage());
      header("location: ../programmeCoordinator/pcIndex.php");
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Request Form</title>
    <link rel="stylesheet" href="../programmeCoordinator/pc_dash.css" />
</head>
<body>


<?php include_once "../programmeCoordinator/pcDashboard.php";?>

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
      if($row["serv_id"] <> 1 && $row["status_id"]==1){
        echo '<div class="input-group">
        <label for="description" class="input-label">My Recommendation</label>
        <textarea class="form-control" id="description" aria-label="With textarea"  readonly>';
          echo $row["Recommendation"]. '</textarea>';
        echo '</div>';
      }
    ?>
    
    <div class="mt-3">
      <button class="btn btn-secondary"   data-bs-toggle="modal" data-bs-target="#exampleModal"  type="button">Process Detail<button>
        </div>
    
    <form  method="post" enctype="multipart/form-data">

            </div>
              
            <?php
                $stmt1=$pdo->prepare("select  form ,status_id from pc_process where req_id=:id");
                $stmt1->execute(array(':id'=>$id));
                $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
                if($row["status_id"]==5){
                  if(!$row1["form"] && $row["serv_id"]==1)
                  {
                    echo ' <div class="input-group">';
                    echo '<label for="form" class="input-label">Upload Forms</label>';
                    echo '<input type="file"  name="form">';
                    echo ' </div>';
                    echo '<div class="d-grid gap-3 d-md-block">

                      <button class="btn btn-primary"  name="btnsend"   type="submit">Send</button>
                    <a href="../programmeCoordinator/pcIndex.php" class="btn btn-primary " >Back Home</a>
                  </div>';
                  }else{
                    echo '<div class="d-grid gap-3 d-md-block">

                    <button class="btn btn-primary"   data-bs-toggle="modal" data-bs-target="#RecommendationModal"  type="button">Add Recommendation</button>

                    <a href="../programmeCoordinator/pcIndex.php" class="btn btn-primary" >Back Home</a>
                  </div>';
                  }
                }else{
                  echo '<a href="../programmeCoordinator/pcIndex.php" class="btn btn-primary" >Back Home</a>';
                }

                
            ?>
          
      </form>
          
      
        
        

        <?php
              function getFinanceClearance($id){

                global $pdo;

                $sql=$pdo->prepare("select CONCAT(f.f_lname,' ',f.f_fname) AS fn , f.f_umail from finance_process fp , finance f where fp.f_id=f.f_id AND fp.req_id=:id");
                $sql->execute(array(":id"=>$id));
                $row=$sql->fetch(PDO::FETCH_ASSOC);

                $fn=$row["fn"];
                $email=$row["f_umail"];

                $info=$fn."-".$email;

                return  $info;


              }
              
              function getRcClearance($id){

                global $pdo;

                $sql=$pdo->prepare("SELECT CONCAT(rc.rc_lname,' ',rc.rc_fname) AS fn , rc.rc_umail FROM rc_process rcp , resource_center rc WHERE rcp.rc_id =rc.rc_id AND rcp.req_id=:id");
                $sql->execute(array(":id"=>$id));
                $row=$sql->fetch(PDO::FETCH_ASSOC);

                $fn=$row["fn"];
                $email=$row["rc_umail"];

                $info=$fn."-".$email;

                return  $info;


              }

              $rcInfo=getRcClearance($id);
              $financeInfo=getFinanceClearance($id);
              
              
        ?>
        <!-- Modal Start Here-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel">Clearance Process</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="recipient-name " class="col-form-label text-dark ">Clearance From Finance-Given By</label>
            <input type="text" class="form-control  fw-semibold"  value="<?php echo  $financeInfo ; ?>" readonly>
            
          </div>
          <div class="mb-3">
            <label for="recipient-name " class="col-form-label text-dark">Clearance From Resource Center-Given By</label>
            <input type="text" class="form-control fw-semibold" value="<?php echo  $rcInfo ; ?>" readonly>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
      <!-- Modal Start End-->
        
        <!-- Recommendation Modal Start Here-->
<div class="modal fade" id="RecommendationModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-semibold" >Recommendation For The Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
        <div class="mb-3">
            <label for="message-text" class="col-form-label text-dark">Add Recommendation</label>
            <textarea class="form-control" name="recommendation"></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="btnsend"  data-bs-dismiss="modal">Confirm</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>
        <!-- Modal RECOMMENDATION Stop End-->
        
      
    </div>

<script src="script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
