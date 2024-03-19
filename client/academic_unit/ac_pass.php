<?php
//!Include your database connection file
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();
$isValid=true;
if (!isset($_SESSION['acid'])) {
    
    header('Location: ../Login/login.php'); 

} 

$stmt=$pdo->prepare("SELECT acu_password from academic_unit where acu_id=:id");
$stmt->execute(array(":id"=>$_SESSION['acid']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

$error1=$error2=$error3=$msg="";

if(isset($_POST["btnsubmit"])){
  $oldpwd=validateInput($_POST["oldpwd"]);
  $nwpwd=validateInput($_POST["nwpwd"]);
  $cnpwd=validateInput($_POST["confirmpassword"]);
  $oldPassoword= hash('md5',$oldpwd);//*ENCRYPT PASSWORD

if($oldPassoword!= $row["acu_password"]){
    $error1="Invalid Password";
    $isValid=false;
}
if($nwpwd != $cnpwd){
    $error2="Password does not matched";
    $isValid=false;
}

if (strlen($nwpwd) < 8) {
    $error3 = "Password must be at least 8 characters long";
    $isValid = false;
}
if($isValid){
    $msg=changePassword($nwpwd);
        echo '<script>
        setTimeout(function() {
        window.location.href = "../login/logout.php";
        }, 2000);
        </script>';
}



}
function changePassword($nwpwd){
  global $pdo;
  $check = hash('md5', $nwpwd);
  $sql="UPDATE academic_unit set acu_password=:nwpwd where acu_id=:id";
  $stmt1=$pdo->prepare($sql);
  $stmt1->execute(array(":nwpwd"=>$check,":id"=>$_SESSION['acid']));
  return $msg="Password Changed Successfully";
}

function validateInput($data){
  $data =trim($data);
  $data =stripslashes($data);
  $data=htmlspecialchars($data);

  return $data;

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>change Password </title>
    
</head>
<body>


    <?php include_once "../academic_unit/ac_dash.php";?>
<div class="mainDiv">
    <div class="cardStyle">
      <form action="" method="post" >
        
        <h2 class="formTitle">
          Modify Password
        </h2>
        <div class="inputDiv">
            <label class="inputLabel" for="password">Existing Password</label>
            <input type="password"  name="oldpwd" autocomplete="off">
            <span class="text-danger"><?php echo $error1;?></span>
          
          </div>
      <div class="inputDiv">
        <label class="inputLabel" for="password">New Password</label>
        <input type="password"  name="nwpwd"  autocomplete="off">
        <span class="text-danger"><?php  echo $error2;?></span>
      </div>
        
      <div class="inputDiv">
        <label class="inputLabel" for="confirmPassword">Confirm Password</label>
        <input type="password"  name="confirmpassword"  autocomplete="off">
        
      </div>
      
      <div class="buttonWrapper text-center">
      <span class="text-danger fw-semibold"><?php  echo $error3; ?></span>
      <span class="text-success"><?php  echo $msg;?></span>
        <button type="submit"  name="btnsubmit"  id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
          Change Password
        
        </button>
      </div>
        
    </form>
    </div>
  </div>
      
      


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>