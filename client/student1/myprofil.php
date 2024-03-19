<?php
session_start();
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
if(!isset($_SESSION["sid"])){
    header("location:../student1/studentLogin.php");
}

$selectInfo=$pdo->prepare("SELECT s.s_lname AS LN, s.s_fname AS FN ,s.s_pin AS PN, c.cohort_name ,s.s_umail AS EM FROM student s ,cohort c WHERE s.cohort_id =c.cohort_id AND s.s_id=:id");
$selectInfo->execute(array(":id"=>$_SESSION["sid"]));
$studentInfo=$selectInfo->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../student1/student.css">
    <title>Document Management System</title>
</head>
<body>
<?php include_once "../student1/studentDash.php"; ?>

    <div class="cardProfile" style="width: 48rem;">
        <div class="card  bs-light-rgb" >
            <div class="card-body">
            <h3 class="card-title m-3 fw-semibold border-bottom">My Profile</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label  class="form-label ">Last name</label>
                        <input type="text" class="form-control border-0 border-bottom text-capitalize"  value="<?php echo htmlspecialchars($studentInfo["LN"])?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label ">First name</label>
                        <input type="text" class="form-control border-0 border-bottom text-capitalize"  value="<?php echo htmlspecialchars($studentInfo["FN"])?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label ">Student ID</label>
                        <input type="text" class="form-control border-0 border-bottom"  value="<?php echo htmlspecialchars($studentInfo["PN"])?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label ">Cohort</label>
                    <input type="text" class="form-control border-0 border-bottom text-capitalize"  value="<?php echo htmlspecialchars($studentInfo["cohort_name"]) ?>" readonly>
                    </div>
                    <div class="col-md-12">
                        <label  class="form-label ">Email</label>
                        <input type="text" class="form-control border-0 border-bottom"  value="<?php echo htmlspecialchars($studentInfo["EM"])?>" readonly>
                    </div>
                    <div class="mb-5"></div>
                </div>
        </div>  
    </div>

</body>
</html>