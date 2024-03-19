<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
if(!isset( $_SESSION["id"])){
    header("location ../login-Asset/adminlogin.php");
}
$isvalid=true;
$error1='';
    $error2='';
    $error3='';
    $program='';
if(isset($_GET["q"])){

    $stmt =$pdo->prepare("SELECT p.prog_id ,p.prog_name ,p.prog_acro ,s.School_acronym FROM programme p ,school s where p.school_id=s.school_ID AND p.prog_id=:id");
    $stmt->execute(array(":id"=>$_GET["q"]));

    if ($stmt->rowCount() < 1) {
        header("Location: ../mainadmin/program.php");
        exit();
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    header("location ../mainadmin/program.php");
}

    
    

    if (isset($_POST['btnadd'])){
        try{
            $program = validate_input($_POST['nwprog']);
            $prog_acro = validate_input($_POST['prog_acro']);
            $school=$_POST['scid'];
            
            
            if (preg_match('/[^A-Za-z0-9\s]/', $program )|| preg_match('/[0-9]/', $program ) || empty($program) ) { // ?validation for (special characters or numeric values)
                $error2='Invalid Input';
                $isvalid=false;
            } 
            
            if (preg_match('/[^A-Za-z0-9\s]/',  $prog_acro)|| preg_match('/[0-9]/',  $prog_acro ) || empty( $prog_acro) ) { // ?validation for (special characters or numeric values)
                $error1='Invalid Input';
                $isvalid=false;
            } 
            if($school=="-1"){
                $error3="Invalid Input";
                $isvalid=false;
            }
            $stmt=$pdo->prepare("select * from programme where prog_name = :prog_name");
            $stmt->execute(array(":prog_name"=>$program));
            $rows1=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $rows1=$stmt->rowcount();

            if($rows1 > 1 ){
                $error1='Programme Already Exist'; //! Need to debug validation is not working
                $isvalid=false;
            }
            if($isvalid){
                // *INSERT STATEMENT FOR PROGRAMME TABLE
                $sql ="UPDATE programme SET prog_name =:prog_name,prog_acro=:prog_acro,school_id=:id where prog_id=:pid";
                $stmt = $pdo ->prepare($sql);
                $stmt->execute(array(':prog_name'=>$program,
                                    ':prog_acro'=>strtoupper($prog_acro),
                                    ':id'=>$school,
                                    ':pid'=>$_GET["q"]));

                header("location: ../mainadmin/program.php");
            }
        } catch (Exception $e){
            error_log('Error: ' . $e->getMessage());
            header("location: ../mainadmin/program.php");
        }
        

    }

function validate_input($data){ 
    //Remove any html characters before inserting
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
    <title>Update Programme</title>
    

</head>
<body>



<?php include_once "../mainadmin/dashboard.php" ?>

    <div class="container-fluid">
        <div class="card-container">
            <div class="row">
                <div class="col">
                    <div class="card mb-3" style="width: 60rem;">
                        <div class="card-body">
                            <form class="row g-5" method="post">
                                
                            
                                <div class="col-auto">
                                    
                                    <input type="text" class="form-control" name='nwprog'  placeholder="New Program">
                                    <span class="text-danger m-2"><?php echo $error1; ?></span>

                                </div>
                                <div class="col-auto">
                                    
                                    <input type="text" class="form-control" name='prog_acro'  placeholder="Program Acronym" >
                                    <span class="text-danger m-2"><?php echo $error2; ?></span>

                                </div>
                                
                                <div class="col-auto">
                                    
                                <select class="form-select" aria-label="Default select example" name="scid">
                                    <option selected value="-1">School</option>
                                    <?php
                                        $sql2=$pdo->query("SELECT * FROM school");
                                    while($row2=$sql2->fetch(PDO::FETCH_ASSOC)){
                                        echo '<option value="' . $row2['school_ID'] . '">' . htmlspecialchars($row2['School_acronym']).  '</option>';
                                    }

                                    ?>

                                </select>
                                <span class="text-danger m-2"><?php echo $error3; ?></span>
                                </div>
                                
                                <div class="col-auto ">
                                    <button type="submit"  name="btnadd" class="btn btn-primary me-3">update</button>
                                    <a  href="../mainadmin/program.php" class="btn btn-primary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            
                <div class="col">
                    <div class="card mb-3" style="width: 60rem;">
                    <h3 class="m-3 fw-semibold">Current Program To Update</h3>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr class="text-center">
                                    
                                    <th scope="col">Program Name</th>
                                    <th scope="col">Acronym</th>
                                    <th scope="col">School</th>
                                    
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($rows as $row){
                                        echo '<tr class="text-center">';
                                        
                                        echo '<td >';
                                        echo $row["prog_name"];
                                        echo '</td><td>';
                                        echo $row["prog_acro"];
                                        echo '<td>';
                                        echo $row["School_acronym"];
                                        
                                        
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