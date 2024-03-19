<?php
session_start();
if(!isset( $_SESSION["id"])){
    header("location ../login-Asset/adminlogin.php");
}
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if(isset($_GET['sid'])){
    try {
        $error='';
        $stmt=$pdo->prepare('select serv_name from service where serv_id =:servid');
        $stmt->execute(array(":servid"=>$_GET['sid']));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row==false){
            header("Location:services.php");

        }else{
            
            $servname=htmlentities($row['serv_name']);
        }
    }
    catch (Exception $e) {
        echo $e->getMessage();
        header("Location:services.php");

    }
        
        
    
}  else {
    header("Location:services.php");
}

if (isset($_POST['btnsubmit'])){
    $req=validate_input($_POST['nwreq']);
    $flag=check_service($req,$pdo);
    if (preg_match('/[^A-Za-z0-9\s]/', $req)|| preg_match('/[0-9]/', $req)|| empty($req)){ // ?validation for (special characters, numeric values, or white spaces)
        $error='Invalid Input';
    } elseif ($flag==true) {
        $error="Service Already Exist";
    
    } else {
        // *UPDATE STATEMENT FOR SERVICES
        
        
        $sql='update service set serv_name = :req   where serv_id = :sid';
        $stmt=$pdo->prepare($sql);

        $stmt->execute(array(
            ':req' =>$req,
            ':sid'=>$_GET['sid']
        ));
        header('Location:services.php');

    }

}

function check_service($req,$pdo){ 
    // *Function to check if services already exist

    $stmt= $pdo->prepare("select * from service where serv_name= :req");
    $stmt->execute(array(":req"=>$req));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rows > 1){
        $flag=true;

    }else{
        $flag=false;
    }

    return $flag;

}
function validate_input($data){ 
    // *Remove any html characters before inserting
    $data = trim($data); 
    $data = stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Update Services</title>



</head>
<body>
    <?php  include_once "../mainadmin/dashboard.php" ?>
    <div class="container-fluid">
    
        <div class="card-container">

            <div class="row">
                
                
                <div class="col">
                    <div class="card mb-3" style="width: 35rem;">
                        <div class="card-body">
                            <form method="post"  class="row g-5">
                                <div class="col-auto">
                                    <input type="text" class="form-control" value='<?php echo $servname; ?>' readonly>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control"  name='nwreq' placeholder="New Services">
                                    <span class="text-danger m-2"><?php echo $error; ?></span>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name='btnsubmit' class="btn btn-primary mb-3">Update Request</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    
</body>
</html>