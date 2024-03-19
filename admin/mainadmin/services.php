<?php
session_start();
if(!isset( $_SESSION["id"])){
    header("location ../login-Asset/adminlogin.php");
}
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
$stmt=$pdo->query("select * from service"); //query to to select service 
$rows= $stmt->fetchAll(PDO::FETCH_ASSOC);
$req=$error='';

if (isset($_POST['btnsubmit'])){
    $req=validate_input($_POST['nwreq']);

    if (preg_match('/[^A-Za-z0-9\s]/', $req)|| preg_match('/[0-9]/', $req)||  empty($req)){ // ?validation for (special characters, numeric values, or white spaces)
        $error='Invalid Input';
    } else {
        // *INSERT STATEMENT GOES HERE

        $sql="INSERT INTO service (serv_name) values (:srv_name)";
        $stmt=$pdo->prepare($sql);
        $stmt ->execute(array(':srv_name'=>$req));
        header("location:services.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Services</title>
   


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
                                    
                                    <?php
                                        if(!empty($error)){
                                            echo '<input type="text" class="form-control  border-bottom border-danger" name="nwreq" id="nwreq" placeholder="New Request">';
                                        } else {
                                            echo '<input type="text" class="form-control" name="nwreq" id="nwreq" placeholder="New Request">';
                                        }
                                    ?>
                                    
                                    <span class='text-danger m-3 mt-4' id="error"><?php echo $error; ?></span>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name='btnsubmit' class="btn btn-primary mb-3">Add Service</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col">
                    <div class="card mb-3" style="width: 35rem;">
                        <div class="card-body">
                            <h3 class="text-center">All Services </h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        
                                        <th scope="col">Service Title</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($rows as $row){
                                                

                                                echo "<tr><td>";
                                                echo($row['serv_name']);
                                                echo "</td><td>";
                                                echo '<form action="uptservices.php?sid='. $row['serv_id'] . ' " method="POST">';

                                                
                                                echo '<div class="dropdown">';
                                                echo '<button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>';
                                                echo '<ul class="dropdown-menu">
                                                    
                                                    <li><button class="dropdown-item" type="submit" name="btnupt">Update</button></li>
                                                    </ul>';
                                                    
                                                echo "</div>";
                                                echo "</td></tr>";
                                                echo '</form>';
                                            }
                                            
                                        ?>
                                    
                                    
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
</body>
</html>