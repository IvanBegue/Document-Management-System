<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";


if(!isset($_SESSION["id"])){
    header("location ../login-Asset/adminlogin.php");
}
$error1=$error2=$error3='';
$isvalid=true;

if(isset($_GET["q"]))
{
    $sql=$pdo->prepare("SELECT c.cohort_id ,c.cohort_name ,p.prog_name ,CONCAT(pc.pc_lname,' ',pc.pc_fname)AS FN,s.school_acronym FROM cohort c ,programme p , program_coordinator pc,school s where c.prog_id=p.prog_id AND c.pc_id=pc.pc_id AND p.school_id=s.school_ID AND p.prog_id=:id");
    $sql->execute(array(":id"=>$_GET["q"]));
    $rows=$sql->fetch(PDO::FETCH_ASSOC);

    if ($sql->rowCount() < 1) 
    {
        header("Location: ../mainadmin/cohort.php");
        exit();
    }
    

}else{
    header("Location: ../mainadmin/cohort.php");
}




if(isset($_POST['btnadd'])){
    try{
        $cohort=validate_input($_POST["cohort"]);
        $programme=($_POST["programme"]);
        $pc=($_POST["pc"]);
        
        if(preg_match('/\s/', $cohort) || empty($cohort)){
            $error1='Invalid Input';
            $isvalid=false;
        }
        if($programme=="-1"){
            $error2='Choose an option';
            $isvalid=false;
        }
        if($pc=="-1"){
            $error3='Choose an option';
            $isvalid=false;
        }
        
        if($isvalid){
            $sql="UPDATE cohort SET cohort_name =:cname,prog_id=:progid,pc_id=:pcid WHERE cohort_id=:id";
            $stmt=$pdo->prepare($sql);
            $stmt->execute(array(":cname"=>$cohort,":progid"=>$programme,":pcid"=>$pc,":id"=>$_GET["q"]));
            header("location: ../mainadmin/cohort.php");

        }
    }
    catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        header("location: ../mainadmin/cohort.php");
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cohort Details</title>
    


</head>
<body>
    <?php  include_once "../mainadmin/dashboard.php" ?>
    <div class="container-fluid">
        <div class="card-container">
            <div class="row">
                <div class="col">
                    <div class="card mb-3" style="width: 60rem;">
                        <div class="card-body">
                             
                            <form method="POST" class="row g-5">
                                <div class="col-auto">
                                    
                                <input type="text" class="form-control" value="<?php echo $rows["cohort_name"] ?>"name="cohort" placeholder="Update Cohort">
                                    <span class='text-danger m-2'><?php echo $error1?></span>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="programme" >
                                        <option value="-1">Programme</option>
                                        <?php
                                        $sql1=$pdo->query("SELECT * FROM Programme");
                                            while($row1=$sql1->fetch(PDO::FETCH_ASSOC)){
                                                echo '<option value="' . $row1['prog_id'] . '">' . htmlspecialchars($row1['prog_name']).  '</option>';
                                            }

                                        ?>
                                    </select>
                                    <span class='text-danger m-2'><?php echo $error2?></span>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="pc" >
                                    <option value="-1">Programme Coordinator</option>
                                        <?php
                                        $sql3=$pdo->query("SELECT * FROM program_coordinator");
                                            while($row3=$sql3->fetch(PDO::FETCH_ASSOC)){
                                                echo '<option value="' . $row3['pc_id'] . '">' . htmlspecialchars($row3['pc_lname'])." ".htmlspecialchars($row3['pc_fname']).  '</option>';
                                            }

                                        ?>
                                    </select>
                                    <span class='text-danger m-2'><?php echo $error3?></span>
                                </div>
                                
                                
                                <div class="col-auto">
                                    <button type="submit"name="btnadd" class="btn btn-primary mb-3">Update Cohort</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card mb-3" style="width: 60rem;">
                        <div class="card-body">
                            <h3 class="m-3 fw-semibold p-2">Current Cohort To Update</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr class="text-center">
                                        
                                        <th scope="col">Cohort</th>
                                        <th scope="col">Program Name</th>
                                        <th scope="col">Program Coordinator</th>
                                        <th scope="col">School</th>
                                        
                                        
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php
                                        
                                            echo "<tr  class='text-center'>";
                                            echo "<td class='text-capitalize'>" . $rows['cohort_name'] . "</td>";
                                            echo "<td>" . $rows['prog_name'] . "</td>";
                                            echo "<td class='text-capitalize'>" . $rows['FN'] . "</td>";
                                            echo "<td class='text-capitalize'>" . $rows['school_acronym'] . "</td>";

                                            echo "</tr>";
                                        
                                        ?>
                                    
                                        
                                       
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    
</body>
</html>