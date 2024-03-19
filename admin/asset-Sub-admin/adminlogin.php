<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php'; // !Load the database configuration file
session_start();
$error="";

    function validate_input($data){ 
        //*sanitanize Input
        $data = trim($data); 
        $data = stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
if(isset($_POST["btnlog"])){
        
    try{
        $pn=validate_input($_POST["pin"]);
        $pwd=validate_input($_POST["pwd"]);
        $CheckPin = substr($pn,0,4);

        if($CheckPin=="6782"){ //*For Table SubAdmin
            $stmt=$pdo->prepare("SELECT * FROM sub_admin where sub_a_pin = :pn and sub_a_pwd = :pwd");
            $stmt->execute(array(":pn"=>$pn,
                                ":pwd"=>$pwd));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $count=$stmt->rowcount();
                if($count==1){
                    $_SESSION["id"]=$row["sub_a_id"];
                    $_SESSION["fn"]=$row["sub_Fname"];
                    header("location:dashboard.php");


                }else {
                    $error="Invalid Credential";
                }

        }elseif($CheckPin=="9735"){ //* For Table Admin
            $stmt=$pdo->prepare("SELECT * FROM admin where adm_pin = :pn and adm_password = :pwd");
            $stmt->execute(array(":pn"=>$pn,
                                ":pwd"=>$pwd));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $count=$stmt->rowcount();
                if($count==1){
                    $_SESSION["aid"]=$row["adm_pin"];
                    $_SESSION["afn"]=$row["adm_name"];
                    header("location:dashboard.php");


                }else {
                    $error="Invalid Credential";
                }

        }else{
            $error="Invalid Credential";

        }



    } catch(Exception $e){
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
    <title>Admin Login</title>
    <!--Boostrap Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../asset-sub-admin/adminLogin.css">

</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <img src="UTM.png" alt="Logo" class="logo">
        <h1 class="title">Document Management System <br>University Of Technology, Mauritius</h1>
    </div>
    <div class="login-background">
        <form  method="post" >
            <div class="login-box">
                <div class="login-header">
                    <header>Admin Login</header>
                    
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" name="pin" placeholder="Pin" autocomplete="off" >
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" name="pwd" placeholder="Password" autocomplete="off">
                </div>
                <div class="forgot">
                    <section>
                        <input type="checkbox" id="check">
                        <label for="check">Remember me</label>
                    </section>
                    <section>
                        <a href="forgot.html">Forgot password</a>
                    </section>
                </div>
                <span class="text-danger text-center"></span>
                <div class="input-submit">
                    <button class="submit-btn" name="btnlog" id="submit"></button>
                    <label for="submit">Log In</label>
                </div>
                
                
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
