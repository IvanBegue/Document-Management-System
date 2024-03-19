<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; //!Include your database connection file
session_start();
$error1=$error2=$msg=$error3="";
$isValid=true;
if(!isset($_SESSION["sid"])){
    header("location:../student1/studentLogin.php");
}
/*SELECTING PASSWORD*/ 
$stmt=$pdo->prepare("SELECT s_password from student where s_id=:id");
$stmt->execute(array(":id"=>$_SESSION["sid"]));
$row=$stmt->fetch(PDO::FETCH_ASSOC);



if(isset($_POST["btnsubmit"])){
  $oldpwd=validateInput($_POST["oldpwd"]);
  $nwpwd=validateInput($_POST["nwpwd"]);
  $cnpwd=validateInput($_POST["confirmpassword"]);

  $oldPassoword = hash('md5',$oldpwd);

  if( $oldPassoword != $row["s_password"]){
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

}

function changePassword($nwpwd){
  global $pdo;
  $check = hash('md5', $nwpwd);
  $sql="UPDATE student set s_password=:nwpwd where s_id=:id";
  $stmt1=$pdo->prepare($sql);
  $stmt1->execute(array(":nwpwd"=> $check,":id"=>$_SESSION["sid"]));
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

<?php include_once "../student1/studentDash.php"; ?>
<div class="mainDiv">
    <div class="cardStyle">
      <form  method="POST" >
        
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
        <span class="text-danger fw-semibold "><?php  echo $error3; ?></span>
        <span class="text-success"><?php  echo $msg;?></span>
        <button type="submit"  name="btnsubmit"   class="submitButton pure-button pure-button-primary">
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