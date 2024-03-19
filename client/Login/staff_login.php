<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php'; // Load the database configuration file
session_start();
$error="";

function validate_input($data)
{
    // Sanitize Input
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["btnlog"])) {

    try {
        $pn = validate_input($_POST["pin"]);
        $pwd = validate_input($_POST["password"]);
        $check=hash("md5",$pwd); //*MD5 
        $CheckPin = substr($pn, 0, 4);
        error_log($CheckPin);

        if ($CheckPin=="5305") { //*For Table Resource Center
            $stmt = $pdo->prepare("SELECT * FROM resource_center  where rc_pin = :pn and rc_password = :pwd");
            $stmt->execute(array(":pn"=>$pn,
                ":pwd"=>$check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count==1){
                    $_SESSION["rcid"]=$row["rc_id"];
                    echo error_log("Login as RC".$_SESSION["rcid"]);
                    header("location: ../resouce_center/rcindex.php");//*Redirect on RC dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }

        } elseif ($CheckPin=="5301") { //* For Table Finance
            $stmt = $pdo->prepare("SELECT * FROM finance where f_pin = :pn and f_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1){
                    $_SESSION["fid"] = $row["f_id"];
                    echo error_log("Login as Finance".$_SESSION["fid"]);
                    header("location: ../finance/financeindex.php"); //*Redirect on Finance Dashboard
                } else {
                    $error="Invalid Credential";
                    error_log($error);
                    
                }
        } elseif ($CheckPin =="9891") { //* For Table Pc
            $stmt = $pdo->prepare("SELECT * FROM program_coordinator where pc_pin = :pn and pc_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" =>$check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["pcid"] = $row["pc_id"];
                    echo error_log("Login as pc ".$_SESSION["pcid"] );
                    header("location: ../programmeCoordinator/pcIndex.php"); //*Redirect on PC Dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }
        
                
        }elseif($CheckPin=="4970") {//* For Table student Affairs
            $stmt = $pdo->prepare("SELECT * FROM student_affairs where sa_pin = :pn and sa_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["said"] = $row["sa_id"];
                    echo error_log("Login as student Affairs". $_SESSION["said"]  );
                    header("location: ../student_affair/saindex.php"); //*Redirect on Student Affairs Dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }

        }elseif($CheckPin=="9411"){//* For Table Academic Unit
            $stmt = $pdo->prepare("SELECT * FROM academic_unit where acu_pin = :pn and acu_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["acid"] = $row["acu_id"];
                    echo error_log("Login as Academic Unit". $_SESSION["acid"] );
                    header("location: ../academic_unit/acindex.php"); //*Redirect on Acedemic Unit Dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }
        }elseif($CheckPin=="6088"){//* For Table Registry
            $stmt = $pdo->prepare("SELECT * FROM registry where r_pin = :pn and r_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["rid"] =$row["r_id"];
                    
                    header("location: ../Registry2/RegistryIndex.php"); //*Redirect on Registry Dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }
        }elseif($CheckPin=="2309"){//* For Table HOS  
            
            $stmt = $pdo->prepare("SELECT * FROM hos where hos_pin = :pn and hos_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd"=>$check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["hid"] = $row["hos_id"];
                    echo error_log("Login as HOS". $_SESSION["hid"]  );
                    header("location: ../hos/hos_dash.php"); //*Redirect on HOS Dashboard
                } else {
                    $error = "Invalid Credential";
                    
                }
        }elseif($CheckPin=="6579"){//* For Table Dissertation committee
            $stmt = $pdo->prepare("SELECT * FROM disertation_commitee where dc_pin = :pn and dc_password= :pwd");
            $stmt->execute(array(":pn" =>$pn,
                ":pwd" =>$check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["dcid"] = $row["dc_id"];
                    
                    header("location: ../dissertation_commitee/dcIndex.php"); //*Redirect on Dissertation committee
                } else {
                    $error = "Invalid Credential";
                    
                }
        }elseif($CheckPin=="6571"){//* For Table Exam Unit
            $stmt = $pdo->prepare("SELECT * FROM exam_unit where eu_pin = :pn and eu_password= :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["euid"] = $row["eu_id"];
                    echo error_log("Login as EU". $_SESSION["euid"]  );
                    header("location: ../exam_unit/euIndex.php"); //*Redirect on Exam Unit
                } else {
                    $error = "Invalid Credential";
                    
                }
        }elseif($CheckPin=="8651"){//* For Table DG
            $stmt = $pdo->prepare("SELECT * FROM dg where dg_pin = :pn and dg_password= :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["dgid"] = $row["dg_id"];
                    echo error_log("Login as DG". $_SESSION["dgid"]);
                    //header("location: dashboard.php"); //*Redirect on DG 
                } else {
                    $error = "Invalid Credential";
                    
                }
        }else{
            $error = "Invalid Credential";
            
        }
        
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Login/staff_login.css">
    <title>Staff Login</title>
    
</head>

<body>
    <!-- Banner Section -->
    <div class="banner">
        <img src="UTM.png" alt="Logo" class="logo">
        <h1 class="title fw-semibold">Document Management System <br>University Of Technology, Mauritius</h1>
    </div>
    <div class="login-background">
        <div class="login-box">
            <div class="login-header">
                <header>Staff Login</header>
            </div>
            <form method="POST" action="">
                <div class="input-box">
                    <input type="text" class="input-field" name="pin" id="pin" placeholder="Pin" autocomplete="off" >
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" name="password" id="pwd" placeholder="Password" autocomplete="off" >
                </div>
                <div class="forgot">
                    <section>
                        <input type="checkbox" id="chkrem">
                        <label for="check">Remember me</label>
                    </section>
                    <section>
                        <a href="forgot.html">Forgot password</a>
                    </section>
                </div>
                <?php

                    if (isset($error)) {
                        echo '<div class="text-danger fw-bold text-center mb-3 fs-5">'.$error.'</div>';
                    }
                ?>
                <div class="input-submit">
                    <button type="submit" name="btnlog" class="submit-btn" id="submit" onclick="remem()">Log In</button>
                </div>
            </form>
            
        </div>
    </div>
    <!--Remember be -->
    <script>
        function remem() {
            var pn = document.querySelector("#pin").value;
            var pwd = document.querySelector("#pwd").value;
            var chk = document.querySelector("#chkrem");
            if (chk.checked) {
                localStorage.setItem("lspn", pn);
                localStorage.setItem("lspwd", pwd);

            }
            else {
                localStorage.removeItem("lspn");
                localStorage.removeItem("lspwd");

            }
            }
            function fetchLocalStorage() {
            document.querySelector("#pin").value = localStorage.getItem("lspn");
            document.querySelector("#pwd").value = localStorage.getItem("lspwd");
            }
            window.addEventListener("load", fetchLocalStorage);
    </script>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
