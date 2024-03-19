<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();
if(!isset($_SESSION["rid"])){
    header("Location: ../Login/staff_login.php");
}
$error1=$error2=$error3=$msg="";
$isValid=true;


$stmt=$pdo->prepare("SELECT r_password from registry where r_id=:id");
$stmt->execute(array(":id"=>$_SESSION["rid"]));
$row=$stmt->fetch(PDO::FETCH_ASSOC);



    if(isset($_POST["btnsubmit"])){
    $oldpwd=validateInput($_POST["oldpwd"]);
    $nwpwd=validateInput($_POST["nwpwd"]);
    $cnpwd=validateInput($_POST["confirmPassword"]);

    $oldPassoword=hash('md5',$oldpwd);//*ENCRYPT PASSWORD

    if($oldPassoword!= $row["r_password"]){
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
    $check=hash('md5',$nwpwd);//*ENCRYPT PASSWORD
    $sql="UPDATE registry set r_password=:nwpwd where r_id=:id";
    $stmt1=$pdo->prepare($sql);
    $stmt1->execute(array(":nwpwd"=>$check,":id"=>$_SESSION["rid"]));
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changed Password</title>
</head>
<body>
    
</body>
</html>
<?php include_once "../Registry2/RegistryDashboard.php"; ?>
    <div class="mainDiv">
        <div class="cardStyle">
        
            
            
            
            <h2 class="formTitle">
            Modify Password
            </h2>
            <form  method="post" >
                <div class="inputDiv">
                    <label class="inputLabel" for="password">Existing Password</label>
                    <input type="password"  name="oldpwd" autocomplete="off">
                    <span class="text-danger fw-semibold"><?php  echo $error1; ?></span>
                </div>
                <div class="inputDiv">
                    <label class="inputLabel" for="password">New Password</label>
                    <input type="password"  name="nwpwd" autocomplete="off">
                    <span class="text-danger fw-semibold"><?php  echo $error2; ?></span>
                </div>
            
                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword">Confirm Password</label>
                    <input type="password"  name="confirmPassword"  autocomplete="off">
                </div>
        
                <div class="buttonWrapper text-center">
                    <span class="text-danger fw-semibold"><?php  echo $error3; ?></span>
                    <span class="text-success fw-semibold"><?php  echo $msg;?></span>
                    <button type="submit"  name="btnsubmit" class="submitButton pure-button pure-button-primary">
                    <span>Change Password</span>
                    
                    </button>
                </div>
            
        </form>
        </div>
    </div>