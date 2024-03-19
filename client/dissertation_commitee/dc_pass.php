<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
session_start();

if(!isset($_SESSION["dcid"])){  //*Redirect To Login
  header("Location: ../Login/login.php");
} 
$error1=$error2=$error3=$msg="";
$isValid=true;

if(isset($_POST["btnsubmit"])){
  try{
    $stmt=$pdo->prepare("SELECT dc_password from disertation_commitee where dc_id=:id");
  $stmt->execute(array(":id"=>$_SESSION["dcid"]));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);

    $oldpwd=validateInput($_POST["oldpwd"]);
      $nwpwd=validateInput($_POST["nwpwd"]);
      $cnpwd=validateInput($_POST["confirmpassword"]);
      $oldPassoword= hash('md5',$oldpwd);//*ENCRYPT PASSWORD

      if($oldPassoword!=$row["dc_password"]){
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
          }, 3000);
        </script>';
        }
    
  }catch(exception $e){
    error_log('Error: ' . $e->getMessage());
    header("location:../dissertation_commitee/dcIndex.php");
  }
}


  function changePassword($nwpwd){
        global $pdo;
        $check = hash('md5', $nwpwd);
        $sql="UPDATE disertation_commitee set dc_password=:nwpwd where dc_id=:id";
        $stmt1=$pdo->prepare($sql);
        $stmt1->execute(array(":nwpwd"=>$check ,":id"=>$_SESSION["dcid"]));
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

<?php include_once "../dissertation_commitee/dc_dash.php"; ?>

    
<div class="mainDiv">
    <div class="cardStyle">
      <form  method="post" >
        
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
      <span class="text-success fw-semibold"><?php  echo $msg;?></span>
        <button type="submit"  name="btnsubmit"  id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
          Change Password
        
        </button>
      </div>
        
    </form>
    </div>
  </div>
      
    

<!-- JavaScript -->
<script src="script.js"></script>
<script src="pw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>