<?php 
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
    

        /*if(!isset($_SESSION["id"])){
            header("location:  ../login-Asset/adminlogin.php");
        }*/

    $isvalid=true;



    function checkPC($cohortID,$newID){
        global $pdo;
        $isfound=false;
        $sql=$pdo->prepare("select * FROM cohort where cohort_id=:cid AND pc_id=:pid");
        $sql->execute(array(":cid"=>$cohortID,
                            ":pid"=>$newID));
        $row=$sql->fetch(PDO::FETCH_ASSOC);
        $count=$sql->rowCount();
        if($count > 0){
            $isfound=true;
        }

        return $isfound;
        

    }

    if(isset($_POST['btnadd'])){
    
        try{
                $newID=$_POST["newID"];
                $cohortID=$_POST["cohortID"];
                $isfound=checkPC($cohortID,$newID);
                if(!$isfound){
                    $sql="UPDATE cohort SET pc_id=:id WHERE cohort_id=:cid";
                    $stmt=$pdo->prepare($sql);

                    $stmt->execute(array(
                                    ':id'=>$newID,
                                    ':cid'=>$cohortID
                    ));
                    $cohort=getCohortName($cohortID);
                    $em=getPcEmail($newID);
                    $sub="UTM Document Management System";
                    $receiverName=getPCfname($newID);
                    $body="Dear $receiverName ,you have been assigned as the Program Coordinator of $cohort. ";
                
                
                sendEmail($em,$sub,$body,$receiverName);
                
                //header("location: ../asset-Sub-admin/Mystaff.php");
                }else{
                    error_log("Operation Failed");
                    //TODO ADD FLASHMESSAGE
                }
                
            
            

        }catch(Exception $e){
            error_log('Error: ' . $e->getMessage());
            
        }

    }

    function getPcEmail($newID){
        global $pdo;
        $sql=$pdo->prepare("SELECT pc_umail FROM program_coordinator WHERE pc_id=:pid");
        $sql->execute(array(":pid"=>$newID));
        $row=$sql->fetch(PDO::FETCH_ASSOC);
        $PcEmail=$row["pc_umail"];
        return $PcEmail;
    }
    
    function getPCfname($newID){
        global $pdo;
        $sql=$pdo->prepare("SELECT pc_fname FROM program_coordinator WHERE pc_id=:pid");
        $sql->execute(array(":pid"=>$newID));
        $row=$sql->fetch(PDO::FETCH_ASSOC);

        $PcFname=$row["pc_fname"];

        return $PcFname;
    }
    function getCohortName($cohortID){
        global $pdo;
        $sql=$pdo->prepare("SELECT cohort_name FROM cohort WHERE cohort_id =:cid");
        $sql->execute(array(":cid"=>$cohortID));
        $row=$sql->fetch(PDO::FETCH_ASSOC);

        $cohortName=$row["cohort_name"];

        return $cohortName;
    }


    ?>
    

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Document Management System</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    
        <!-- navbar -->
        <?php include_once '../asset-sub-admin/dashboard.php'?>
        <!-- navbar -->
        
        <div class="container-fluid">
            <div class="card-container">
                <div class="row">
                    <div class="col">
                        
                        <div class="card mb-3" style="width: 60rem;">
                            <h3 class="ms-3 mt-3 mb-4">Change Program Coordinator</h3>
                            <div class="card-body">
                                
                                    <form class="row g-3" method="post" >
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Select Cohort</label>
                                            <select class="form-select  mb-3" aria-label="Large select example"  name="cohortID" >
                                                <option selected value="">Cohort</option>
                                            <?php
                                                $sql2="SELECT * FROM cohort";
                                                $stmt2 = $pdo->query($sql2);
                                                
                                                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $row['cohort_id'] . '">' . htmlspecialchars($row['cohort_name']).  '</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Change To</label>
                                            <select class="form-select  mb-3" aria-label="Large select example" name="newID" >
                                                <option selected value="">Program Coordinator</option>
                                            <?php
                                                $sql2="SELECT * FROM program_coordinator";
                                                $stmt2 = $pdo->query($sql2);
                                                
                                                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $row['pc_id'] . '">' . htmlspecialchars($row['pc_lname']) ." " .htmlspecialchars($row['pc_fname']) . '</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                        <button class="btn btn-primary" name="btnadd" type="submit">Add</button>
                                        <a  href="#" class="btn btn-primary">Cancel</a>
                                        </div>
                                    </form>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            
        </div>
  
        

        <script>
            // Add an event listener to the "Existing Program Coordinator" dropdown
            document.getElementById("existing_pc").addEventListener("change", function () {
                // Get the selected value from the "Existing Program Coordinator" dropdown
                var selectedValue = this.value;

                // Get the "Change To" dropdown
                var changeToDropdown = document.getElementById("change_to_pc");

                // Clear existing options in the "Change To" dropdown
                changeToDropdown.innerHTML = "";

                // Add the default option
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Program Coordinator";
                changeToDropdown.appendChild(defaultOption);

                // Fetch data for the "Change To" dropdown based on the selected value
                if (selectedValue !== "") {
                    // Use AJAX or any other method to fetch the data from your database
                    // and populate the "Change To" dropdown accordingly
                    // Example using a hardcoded array for demonstration purposes
                    var data = [
                        { pc_id: 1, pc_lname: "Doe", pc_fname: "John" },
                        { pc_id: 2, pc_lname: "Smith", pc_fname: "Alice" },
                        // Add more data as needed
                    ];

                    data.forEach(function (row) {
                        var option = document.createElement("option");
                        option.value = row.pc_id;
                        option.text = row.pc_lname + " " + row.pc_fname;
                        changeToDropdown.appendChild(option);
                    });
                }
            });
        </script>
        <script src="/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
    </html>