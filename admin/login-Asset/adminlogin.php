<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["pin"]) && isset($_POST["password"])) {
        try {
            $pin = validate_input($_POST["pin"]);
            $password = validate_input($_POST["password"]);
            $CheckPin = substr($pin, 0, 4);
            $check=hash("md5",$password);
            
            if($CheckPin=="9735") //*Check for admin
            {
                $sql_admin = "SELECT * FROM admin WHERE adm_pin = :pin AND adm_password = :password";
                $stmt_admin = $pdo->prepare($sql_admin);
                $stmt_admin->execute(['pin' => $pin, 'password' => $password]);
                $row1=$stmt_admin->fetch(PDO::FETCH_ASSOC);
              
                
                $_SESSION["id"] = $row1["adm_id"];
                header("location: ../mainadmin/adminindex.php");

            }elseif($CheckPin=="6782"){
                //* check for subadmin
            $sql_subadm = "SELECT * FROM sub_admin WHERE sub_a_pin = :pin AND sub_a_pwd = :password AND dept_id=6";
            $stmt_subadm = $pdo->prepare($sql_subadm);
            $stmt_subadm->execute(array(':pin' => $pin, ':password' => $check));
            $row=$stmt_subadm->fetch(PDO::FETCH_ASSOC);
            $_SESSION["id"] = $row["sub_a_id"];
            header("location: ../asset-Sub-admin/Mystaff.php");
            }else{
                $message="Invalid Credentials";
            }  

            

        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }
    } else {
        $message = 'Pin and Password are Mandatory!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../login-Asset/adminLogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
    <div class="banner">
        <img src="UTM.png" alt="Logo" class="logo">
        <h1 class="title">Document Management System <br>University Of Technology, Mauritius</h1>
    </div>
    <div class="login-background">
        <div class="login-box">
            <div class="login-header">
                <header>Admin / Sub Admin Login</header>
            </div>
            <form method="POST" >
                <div class="input-box">
                    <input type="text" class="input-field" name="pin" placeholder="Pin" autocomplete="off" >
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" name="password" placeholder="Password" autocomplete="off" >
                </div>
                <div class="forgot">
                    <section>
                        <input type="checkbox" id="check">
                        <label for="check">Remember me</label>
                    </section>
                    
                </div>
                <div class="input-submit text-center">
                    <span class="text-danger fw-semibold"><?php echo $message ;?></span>
                    <button type="submit" class="submit-btn text-light" id="submit">Login</button>
                </div>
            </form>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
