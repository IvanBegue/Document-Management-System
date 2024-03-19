<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
require_once 'C:/xampp/htdocs/MiniProject/db/util.php';
session_start();

$randomNumber = rand(4444, 9999);
$pn=9891;
$randomPin =$pn.$randomNumber;
$isvalid=false;
$error1=$error2=$error3=$error4="";

function ValidateInput($data){
    $data=htmlspecialchars($data);
    $data=trim($data);
    $data = stripslashes($data);
    $data=strtolower($data);
    return $data;
}
function IsEmailValid($umail) {
    if (substr($umail, -16) === '@umail.utm.ac.mu') {
        return true;
    }
    return false;
}
if(isset($_POST["btnsubmit"])){
    $lname=ValidateInput($_POST["pc_lname"]);
    $fname=ValidateInput($_POST["pc_fname"]);
    $umail=ValidateInput($_POST["pc_umail"]);
    $address=ValidateInput($_POST["pc_adress"]);
    $mobile=ValidateInput($_POST["pc_mobile"]);
    
    $checklname=preg_match('/^[A-Za-z]+$/', $lname);
    $checkFname=preg_match('/^[A-Za-z]+$/', $fname);

        if(empty($lname)&& !$checklname){
            $error1="Invalid Input";
        }else{
            $isvalid=true;
        }
        
        if(empty($fname) && !$checkFname){
            $error2="Invalid Input";
        }else{
            $isvalid=true;
        }
        if (!IsEmailValid($umail)) {
            $error3='Use a Umail Account';
        } else {
            $isvalid=true;
        }


}   

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--Boostrap Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <title>Add Program Coordinator</title>
        <link rel="stylesheet" href="../hos/hos_history.css" />
    

    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="../hos/images/UTM.png" alt="Description of the image"></i>
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>    
            <i class='bx bx-bell'></i>
        </div>
        
        </nav> 

        <header>
            <h1>Head Of School</h1>
        </header>

    <form  method="POST">
        <div class="container-fluid" style="width: 50rem; margin-left:400px; margin-top:70px;">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold border-bottom m-3">Add New Program Coordinator</h4>
                    <div class="row ">
                        <div class="col-md-6">
                            <label for="pc_lname" class="form-label">Last Name</label>
                            <input type="text" id="pc_lname" class="form-control"  name="pc_lname">
                            <span class="text-danger fw-semibold"><?php echo $error1;?></span>
                        </div>
                        <div class="col-md-6">
                            <label for="pc_fname" class="form-label">First Name</label>
                            <input type="text" id="pc_fname"  class="form-control" name="pc_fname">
                            <span class="text-danger fw-semibold"><?php echo $error2;?></span>
                        </div>
                        <div class="col-md-6">
                            <label for="pc_umail" class="form-label" >Umail Address</label>
                            <input type="email" id="pc_umail" class="form-control"  name="pc_umail">
                            <span class="text-danger fw-semibold"><?php echo $error3;?></span>
                        </div>
                        <div class="col-md-6">
                            <label for="pc_adress" class="form-label">Address</label>
                            <input type="text" id="pc_adress" class="form-control"  name="pc_adress">
                            <span class="text-danger fw-semibold"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="pc_pin" class="form-label">PIN <span class="text-body-secondary fst-italic">Auto Generated </span></label>
                            <input type="text" id="pc_pin" class="form-control"  name="pc_pin" value="<?php echo $randomPin?>" readonly>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="pc_mobile" class="form-label" >Mobile</label>
                            <input type="tel" id="pc_mobile" class="form-control" name="pc_mobile">
                            <span class="text-danger fw-semibold"></span>
                        </div>
                
                    </div>
                </div>
                <div class="col-12 mb-3 ms-3">
                    <button class="btn btn-primary" type="submit" name="btnsubmit">Submit form</button>
                </div>
            </div>
        </div>
    </form>





<!-- sidebar -->
<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="./hos_dash.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
        <li class="item">
                <a href="./hos_history.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon">
                        <i class='bx bxs-user-plus'></i>
                    </span>
                    <span class="navlink text-wrap text-center">New Program Coordinator</span>
                </a>
            </li>
        
            <li class="item">
    <a href="./hos_pass.php" class="nav_link">
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

    </ul>

    </ul>

    <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(hos_lname, ' ', hos_fname) AS FN FROM hos where  hos_id = :id");
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (event) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="date"]');

            for (const input of inputs) {
                if (input.value.trim() === '') {
                    alert('Please fill in all fields.');
                    event.preventDefault();
                    return;
                }
            }
        });
    });
</script>
</body>
</html>