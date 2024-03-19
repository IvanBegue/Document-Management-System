<?php
//!Include your database connection file
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/pdo.php";
session_start();

if(!isset($_SESSION["euid"])){  
  header("Location: ../Login/staff_login.php");
}   

$error1=$error2=$error3=$msg="";
$isvalid=true;
$stmt=$pdo->prepare("SELECT eu_password from exam_unit where eu_id=:id");
$stmt->execute(array(":id"=>$_SESSION["euid"]));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST["btnsubmit"])){


  $oldpwd=validateInput($_POST["oldpwd"]);
  $nwpwd=validateInput($_POST["nwpwd"]);
  $cnpwd=validateInput($_POST["confirmpassword"]);
  $oldpassword=hash('md5',$oldpwd);
  
  
  if($oldpassword!=$row["eu_password"]){
    $error1="Invalid Password";
    $isvalid=false;
  }
  if($nwpwd != $cnpwd){
    $error2="Password does not matched";
    $isvalid=false;
  }
  if(strlen($nwpwd)<8){
    $error3="Password must be at least 8 characters long";
    $isvalid=false;
  }

  if($isvalid)
  {
    $msg=changePassword($nwpwd);
    echo '<script>
          setTimeout(function() {
          window.location.href = "../login/logout.php";
          }, 3000);
        </script>';
  }

    

  }

  function changePassword($nwpwd)
  {
    global $pdo;
    $pwd = hash('md5',$nwpwd);
    $sql="UPDATE exam_unit set eu_password=:nwpwd where eu_id=:id";
    $stmt1=$pdo->prepare($sql);
    $stmt1->execute(array(":nwpwd"=>$pwd,":id"=>$_SESSION["euid"]));
    $msg="Password Changed Successfully";
    return $msg;
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

<?php include_once "../exam_unit/exam_dash.php";?>

<div class="mainDiv">
    <div class="cardStyle">
      <form  method="post" >
        
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
        <span class="text-danger fw-semibold"><?php  echo $error2;?></span>
      </div>
      
      <div class="buttonWrapper text-center">
      <span class="text-success fw-semibold"><?php  echo $msg;?></span>
      <span class="text-danger fw-semibold"><?php  echo $error3;?></span>
        <button type="submit"  name="btnsubmit"  id="submitButton"  class="submitButton pure-button pure-button-primary">
          Change Password
        
        </button>
      </div>
        
    </form>
    </div>
  </div>
      
      


</body>
</html>
