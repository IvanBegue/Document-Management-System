<?php
//!Include your database connection file
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();

if(!isset($_SESSION["rcid"])){  
    header("Location: ../Login/staff_login.php");
} 


$stmt=$pdo->prepare("SELECT rc_password from resource_center where rc_id=:id");
$stmt->execute(array(":id"=>$_SESSION["rcid"]));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

$error1=$error2=$msg=$error3="";
$isValid=true;
if(isset($_POST["btnsubmit"])){
  $oldpwd=validateInput($_POST["oldpwd"]);
  $nwpwd=validateInput($_POST["nwpwd"]);
  $cnpwd=validateInput($_POST["confirmpassword"]);
  $oldPassword= hash('md5',$oldpwd);//*ENCRYPT PASSWORD
  

  if($oldPassword!=$row["rc_password"]){
    $error1="Invalid Password";
    $isValid=false;

  }
  if($nwpwd != $cnpwd){
    $error2="Password does not matched";
    $isValid=false;
  }
  
  if(strlen($nwpwd)<8){
    $error3 = "Password must be at least 8 characters long";
    $isValid = false;
  }

    if($isValid){
      $msg=changePassword($nwpwd);
          echo '<script>
          setTimeout(function() {
          window.location.href = "../login/logout.php";
          }, 3000);
        </script>';
    }

    
  

  
}

function changePassword($nwpwd){
  global $pdo;
  $check = hash('md5', $nwpwd);
  $sql="UPDATE resource_center set rc_password=:nwpwd where rc_id=:id";
    $stmt1=$pdo->prepare($sql);
    $stmt1->execute(array(":nwpwd"=>$check,":id"=>$_SESSION["rcid"]));
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
  
    <title>Changed Password</title>
    
    
</head>
<body>

<?php include_once "../resouce_center/rcdash.php" ?>
  <div class="mainDiv">
      <div class="cardStyle">
        <form action="" method="post" >
          
          <h2 class="formTitle">
            Modify Password
          </h2>
          <div class="inputDiv">
              <label class="inputLabel" for="password">Existing Password</label>
              <input type="password"  name="oldpwd" autocomplete="off">
              <span class="text-danger fw-semibold"><?php echo $error1;?></span>
            
            </div>
        <div class="inputDiv">
          <label class="inputLabel" for="password">New Password</label>
          <input type="password"  name="nwpwd"  autocomplete="off">
          <span class="text-danger fw-semibold"><?php  echo $error2;?></span>
        </div>
          
        <div class="inputDiv">
          <label class="inputLabel" for="confirmPassword">Confirm Password</label>
          <input type="password"  name="confirmpassword"  autocomplete="off">
          
        </div>
        
        <div class="buttonWrapper text-center">
        <span class="text-danger fw-semibold"><?php  echo $error3; ?></span>
        <span class="text-success fw-semibold"><?php  echo $msg;?></span>
          <button type="submit"  name="btnsubmit"  id="submitButton"  class="submitButton pure-button pure-button-primary">
            Change Password
          
          </button>
        </div>
          
      </form>
      </div>
    </div>
      
      


</body>
</html>