<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php'; // Load the database configuration file
session_start();
$error = "";

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
        $CheckPin = substr($pn, 0, 4);
        

        if ($CheckPin=="5305") { //* For Table Resource Center
            $stmt = $pdo->prepare("SELECT * FROM resource_center  where rc_pin = :pn and rc_password = :pwd");
            $stmt->execute(array(":pn"=>$pn,
                ":pwd"=>$pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1){
                    $_SESSION["rcid"]=$row["rc_id"];
                    echo error_log("Login as RC".$_SESSION["rcid"] );
                    header("location: http://localhost/MiniProject/client/resouce_center/rc_dash.php");//*Redirect on RC dashboard
                } else {
                    $error = "Invalid Credential";
                }
        } elseif ($CheckPin == "5301") { //* For Table Finance
            $stmt = $pdo->prepare("SELECT * FROM finance where f_pin = :pn and f_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["fid"] = $row["f_id"];
                    echo error_log("Login as Finance".$_SESSION["fid"]);
                    header("location: http://localhost/MiniProject/client/finance/finance_dash.php"); //*Redirect on Finance Dashboard
                } else {
                    $error = "Invalid Credential";
                }
        } elseif ($CheckPin == "9891") { //* For Table Pc
            $stmt = $pdo->prepare("SELECT * FROM program_coordinator where pc_pin = :pn and pc_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["pcid"] = $row["pc_id"];
                    echo error_log("Login as pc ".$_SESSION["pcid"] );
                    header("location: http://localhost/miniproject/client/programmeCoordinator/pcIndex.php"); //*Redirect on PC Dashboard
                } else {
                    $error = "Invalid Credential";
                }
        
                
        }elseif($CheckPin=="4970") {//* For Table student Affairs
            $stmt = $pdo->prepare("SELECT * FROM student_affairs where sa_pin = :pn and sa_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["said"] = $row["sa_id"];
                    echo error_log("Login as student Affairs". $_SESSION["said"]  );
                    header("location: http://localhost/miniproject/client/student_affair/stud_affair_dash.php"); //*Redirect on Student Affairs Dashboard
                } else {
                    $error = "Invalid Credential";
                }

        }elseif($CheckPin=="9411"){//* For Table Academic Unit
            $stmt = $pdo->prepare("SELECT * FROM academic_unit where acu_pin = :pn and acu_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["acid"] = $row["acu_id"];
                    echo error_log("Login as Academic Unit". $_SESSION["acid"] );
                    header("location: ../client/academic_unit/ac_dash.php"); //*Redirect on Acedemic Unit Dashboard
                } else {
                    $error = "Invalid Credential";
                }
        }elseif($CheckPin=="6088"){//* For Table Registry
            $stmt = $pdo->prepare("SELECT * FROM hos where hos_pin = :pn and hos_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["hid"] =$row["hos_id"];
                    echo error_log("Login as Registry". $_SESSION["hid"] );
                    header("location: ../hos/hos_dash.php"); //*Redirect on Registry Dashboard
                } else {
                    $error = "Invalid Credential";
                }
        /*}elseif($CheckPin=="7367"){//* For Table HOS  
            
            $stmt = $pdo->prepare("SELECT * FROM hos where hos_pin = :pn and hos_password = :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["hid"] = $row["hos_id"];
                    echo error_log("Login as HOS". $_SESSION["hid"]  );
                    header("location: ../hos/hos_dash.php"); //*Redirect on HOS Dashboard
                } else {
                    $error = "Invalid Credential";
                }*/
        }elseif($CheckPin=="6579"){//* For Table Dissertation committee
            $stmt = $pdo->prepare("SELECT * FROM disertation_commitee where dc_pin = :pn and dc_password= :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["dcid"] = $row["dc_id"];
                    echo error_log("Login as DC".$_SESSION["dcid"]  );
                    //header("location: dashboard.php"); //*Redirect on Dissertation committee
                } else {
                    $error = "Invalid Credential";
                }
        }elseif($CheckPin=="6571"){//* For Table Exam Unit
            $stmt = $pdo->prepare("SELECT * FROM exam_unit where eu_pin = :pn and eu_password= :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
                if ($count == 1) {
                    $_SESSION["euid"] = $row["eu_id"];
                    echo error_log("Login as EU". $_SESSION["euid"]  );
                    //header("location: dashboard.php"); //*Redirect on Exam Unit
                } else {
                    $error = "Invalid Credential";
                }
        }elseif($CheckPin=="8651"){//* For Table DG
            $stmt = $pdo->prepare("SELECT * FROM dg where dg_pin = :pn and dg_password= :pwd");
            $stmt->execute(array(":pn" => $pn,
                ":pwd" => $pwd));
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
        echo error_log($error);
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
    }
}
?>