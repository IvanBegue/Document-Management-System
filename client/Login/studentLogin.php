<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
session_start();
$error="";


if(isset($_POST["btnlogin"])){
    $pn = validate_input($_POST["pin"]);
    $pwd = validate_input($_POST["pwd"]);
    $check=hash("md5",$pwd );
    $stmt=$pdo->prepare("select * from student where s_pin =:pn AND s_password=:pwd");
    $stmt->execute(array(":pn"=>$pn,":pwd"=>$check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if($count==1){
        $_SESSION["sid"]=$row["s_id"];
        
        header("location: ../student1/studentIndex.php");

    }else{
        $error="Invalid Credential ";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="../Login/staff_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <img src="UTM.png" alt="Logo" class="logo">
        <h1 class="title">Document Management System <br>University Of Technology, Mauritius</h1>
    </div>
    <div class="login-background">
        <div class="login-box">
            <div class="login-header">
                <header>Student Login</header>
            </div>
            <form  method="POST">
                <div class="input-box">
                    <input type="text" name="pin"  class="input-field" placeholder="Pin" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="password" name="pwd"   class="input-field" placeholder="Password" autocomplete="off" required>
                </div>
                <div class="forgot">
                    <section>
                        <input type="checkbox" id="chkrem"   autocomplete="off">
                        <label for="chkrem">Remember me</label>
                    </section>
                    <section>
                        <a href="#">Forgot password</a>
                    </section>
                </div>
                <div class="text-danger text-center pb-3 fs-5 fw-semibold"><?php echo $error?></div>
                <div class="input-submit">
                    <button class="submit-btn fs-4 fw-semibold" name="btnlogin" id="submit" onclick="remem()">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
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
</body>
</html>