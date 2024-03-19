<?php
//!Include your database connection file
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
session_start();
$isValid=true;
if(!isset( $_SESSION["hid"])){  //*Redirect To Login
  header("Location: ../Login/staff_login.php");

}  

$stmt=$pdo->prepare("SELECT hos_password from hos where hos_id=:id");
$stmt->execute(array(":id"=>$_SESSION["hid"]));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

$error1=$error2=$error3=$msg="";

if(isset($_POST["btnsubmit"])){
  $oldpwd=validateInput($_POST["oldpwd"]);
  $nwpwd=validateInput($_POST["nwpwd"]);
  $cnpwd=validateInput($_POST["confirmpassword"]);
  $oldPassoword= hash('md5',$oldpwd);//*ENCRYPT PASSWORD

  if($oldPassoword!= $row["hos_password"]){
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
  $sql="UPDATE hos set hos_password=:nwpwd where hos_id=:id";
  $stmt1=$pdo->prepare($sql);
  $stmt1->execute(array(":nwpwd"=>$check,":id"=>$_SESSION["hid"]));
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
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Head Of School Password</title>
    <link rel="stylesheet" href="../dissertation_commitee/dc_pass.css" />
</head>
<body>

<!-- navbar -->
<nav class="navbar">
    <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <a href="./hos_dash.php">
        <img src="images/UTM.png" alt="Description of the image"></i>
        </a>
    </div>
    

    <div class="search_bar">
        <input type="text" placeholder="Search">
    </div>

    <div class="navbar_content">
        <i class="bi bi-grid"></i>
       
        <i class='bx bx-bell'></i>
       
          
      </a>
</nav>

    
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
      
      



<!-- sidebar -->
<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        
        <li class="item">
            <a href="./hos_dash.php" class="nav_link">
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
 
        <!-- end -->
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

<!-- JavaScript -->
<script src="script.js"></script>
<script src="pw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>