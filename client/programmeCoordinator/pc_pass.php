<?php
try
{
  //!Include your database connection file
  require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
  require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
  session_start();

  if(!isset($_SESSION["pcid"])){  
      header("Location: ../Login/staff_login.php");
  }  

  $stmt=$pdo->prepare("SELECT pc_password from program_coordinator where pc_id=:id");
  $stmt->execute(array(":id"=>$_SESSION["pcid"]));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);

  $error1=$error2=$error3=$msg="";
  $isvalid=true;
  if(isset($_POST["btnsubmit"])){
    $oldpwd=validate_input($_POST["oldpwd"]);
    $nwpwd=validate_input($_POST["nwpwd"]);
    $cnpwd=validate_input($_POST["confirmpassword"]);
    $oldpassword=hash('md5',$oldpwd);
    
    if($oldpassword!=$row["pc_password"]){
      $error1="Invalid Password";
      $isvalid=false;
    }
    if($nwpwd != $cnpwd){
      $error2="Password does not matched";
      $isvalid=false;
    }
    if(strlen($nwpwd)<8){
      $error3 ="Password must be at least 8 characters long";
      $isvalid=false;
    }

    if($isvalid){
      $msg=changePassword($nwpwd);
          echo '<script>
          setTimeout(function() {
          window.location.href = "../login/logout.php";
          }, 3000);
        </script>';
    }

    
      

    

  }
  
}catch (exception $e){
  error_log("ERROR" .$e->getmessage());
}


function changePassword($nwpwd){
  global $pdo;
  $pwd = hash('md5',$nwpwd);
  $sql="UPDATE program_coordinator set pc_password=:nwpwd where pc_id=:id";
  $stmt1=$pdo->prepare($sql);
  $stmt1->execute(array(":nwpwd"=> $pwd  ,":id"=>$_SESSION["pcid"]));
  $msg="Password Changed Successfully";
  return  $msg;
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

<?php include_once "../programmeCoordinator/pcDashboard.php"; ?>

    
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
      <span class="text-danger fw-semibold"><?php  echo $error3; ?></span>
      <span class="text-success fw-semibold"><?php  echo $msg;?></span>
        <button type="submit"  name="btnsubmit"  id="submitButton"  class="submitButton pure-button pure-button-primary">
          Change Password
        
        </button>
      </div>
        
    </form>
    </div>
  </div>
      
      


<script src="script.js"></script>
<script src="pw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
