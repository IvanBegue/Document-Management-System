<?php
//!Include your database connection file
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';
session_start();

if(!isset($_SESSION["pcid"])){  //*Redirect To Login
    header("Location: http://localhost/miniproject/client/Login/staff_login.php");
}

$stmt=$pdo->query("SELECT * FROM forms  ORDER BY form_id DESC ");
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Forms</title>
</head>
<body>

<?php include_once "../programmeCoordinator/pcDashboard.php"; ?>
<style>
    .bxs-file{
        font-size:8em;
    }
</style>
    
            <div class="allForms" style="width: 50rem; margin-left:400px; margin-top:150px;"> 
                <div class="card" >
                    <div class="card-body">
                        <h4 class="card-title fw-semibold border-bottom m-2">Download Request Forms </h4>
                        <div class="container-fluid text-center">
                            <div class="row">
                                <?php  
                                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                        $document=$row["Form"];
                                        echo '<div class="col-4">';
                                            echo '<div class="p-3">';
                                                echo '<i class="bx bxs-file"></i>';
                                                echo '<a href="DownloadForm.php?file=' . urlencode($document) . '" class="text-decoration-none text-wrap text-capitalize">' .$row["Form_Name"]. '</a>';
                                            
                                            echo '</div>';  
                                            
                                        echo '</div>';
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        



</body>
</html>
