<?php 
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";
    

        if(!isset($_SESSION["id"])){
            header("location:  ../login-Asset/adminlogin.php");
        }

    $isvalid=true;
    $error1=$error2=$error3=$error4=$error5='';
    if(isset($_POST['btnadd'])){
        try{
            $fn=validate_input($_POST['fn']);
            $ln=validate_input($_POST['ln']);
            $email=validate_input($_POST['email']);
            $address=validate_input($_POST['address']);
            $phne=validate_input($_POST['phne']);
            $pdw=12345678;
            $pn=$_POST["pin"];

            $passwod=hash('MD5',$pdw);
            

            if(empty($fn) || is_numeric($fn)){
                $error1="Invalid Input";
                $isvalid=false;
            }
            
            if(empty($ln)||is_numeric($ln)){
                $error2="Invalid Input";
                $isvalid=false;
            }

            if(empty($email)){
                $error3="Invalid Input";
                $isvalid=false;
            }
            if(empty($address)){
                $error4="Invalid Input";
                $isvalid=false;
            }
            if(empty($phne)){
                $error5="Invalid Input";
                $isvalid=false;
            }

            if($isvalid){
                $msg = "
            Dear $ln find attached below your credentials for the document system of UTM :http://localhost/miniproject/client/Login/staff_login.php
            <html>
            <table style='border-collapse: collapse; width: 100%;'>
            <tr style='border: 2px solid #96D4D4;'>
                <th style='border: 2px solid #96D4D4; padding: 8px;'>Access Pin</th>
                <th style='border: 2px solid #96D4D4; padding: 8px;'>Password</th>
            </tr>
            <tr style='border: 2px solid #96D4D4;'>
                <td style='border: 2px solid #96D4D4; padding: 8px;'>$pn</td>
                <td style='border: 2px solid #96D4D4; padding: 8px;'>$pdw</td>
            </tr>
            </table>
            </html>
            ";
            
            $sql="INSERT INTO registry (r_fname,r_lname,r_umail,r_adress,r_pin,r_password,r_mobile,sub_a_id) values(:fn,:ln,:em,:address,:pin,:pwd,:phne,:aid)";
            $stmt=$pdo->prepare($sql);

            $stmt->execute(array(
                                ':fn'=>$fn,
                                ':ln'=>$ln,
                                ':em'=>$email,
                                ':address'=>$address,
                                ':pin'=>$pn,
                                ':pwd'=>$passwod,
                                ':phne'=>$phne,
                                ':aid'=>10
            ));
            $em=$email;
            $sub="UTM Document Management System";
            $body=$msg;
            $receiverName= $fn." ".$ln;
            sendEmail($em,$sub,$body,$receiverName);
            header("location: ../asset-Sub-admin/Mystaff.php");
            }
            


        }catch(Exception $e){
            error_log('Error: ' . $e->getMessage());
            
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
        <title>Document Management System</title>
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
                            <h3 class="ms-3 mt-3 mb-4">Add New Staff</h3>
                            <div class="card-body">
                                
                                    <form class="row g-3" method="post" >
                                        <div class="col-md-4">
                                            <label class="form-label">Firstname</label>
                                            <input type="text" name="fn" class="form-control" >
                                            <span class="text-danger fw-semibold m-2"><?php echo $error1; ?></span>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Lastname</label>
                                            <input type="text" name="ln" class="form-control">
                                            <span class="text-danger fw-semibold   m-2"><?php echo $error2; ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Umail</label>
                                            <input type="text" name="email" class="form-control">
                                            <span class="text-danger fw-semibold   m-2"><?php echo $error3; ?></span>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control">
                                            <span class="text-danger fw-semibold   m-2"><?php echo $error4; ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Mobile</label>
                                            <input type="text" name="phne" class="form-control">
                                            <span class="text-danger fw-semibold   m-2"><?php echo $error5; ?></span>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Access Pin</label>
                                            <?php
                                                $randomNumber = rand(1111, 9999);
                                                echo '<input type="text" name="pin" class="form-control" value="6088' . $randomNumber . '" readonly>';
                                            ?>
                                        </div>
                                        
                                        
                                        <div class="col-12">
                                        <button class="btn btn-primary" name="btnadd" type="submit">Add</button>
                                        <button class="btn btn-primary" type="submit">Cancel</button>
                                        </div>
                                    </form>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            
        </div>

        

        <!-- JavaScript -->
        <script src="/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
    </html>