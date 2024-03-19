<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file


if(!isset($_SESSION["id"])){
    header("location:  ../login-Asset/adminlogin.php");
}
?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--Boostrap Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <title>Document Management System</title>
        <link rel="stylesheet" href="../asset-Sub-admin/subAdmin.css" />

            
        <!-- Show/hide Excel file upload form -->
        <script>
        function formToggle(ID){
            var element = document.getElementById(ID);
            if(element.style.display === "none"){
                element.style.display = "block";
            }else{
                element.style.display = "none";
            }
        }
        </script>

    </head>
    <body>
           <!-- navbar -->
           <?php include_once '../asset-sub-admin/dashboard.php'?>
        <!-- navbar -->

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card-container">
                        <?php
                            if(isset($_SESSION["count"])){
                                echo '<div class="alert alert-success alert-dismissible fade show " role="alert" style="background-color:#54B435; width: 300px; margin-left:700px;">';
                                    echo '<div class=" fs-6 text-center">'; echo $_SESSION["count"] .' '. ' New Records Added</div>';
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                                //delete the session
                                unset($_SESSION["count"]);
                                
                            }
                        ?>
                            <div class="card mb-3" style="width: 55rem;">
                                <h3 class="ms-3 mt-3 mb-4">Add Student</h3>
                                    <div class="card-body">
                                    <div class="row p-3">
                                        <!-- Import link -->
                                        <div class="col-md-12 head">
                                            <div class="float-end">
                                                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import Excel</a>
                                            </div>
                                        </div>
                                        <!-- Excel file upload form -->
                                        <div class="col-md-12" id="importFrm" style="display: none;">
                                            <form class="row g-3" action="processtudent.php" method="post" enctype="multipart/form-data">
                                                <div class="col-auto">
                                                    <label for="fileInput" class="visually-hidden">File</label>
                                                    <input type="file" class="form-control" name="excelFile" id="fileInput" />
                                                </div>
                                                <div class="col-auto"  style="display: flex; flex-direction: column; align-items:start;">
                                                    <input type="submit" class="btn btn-primary mb-3" name="btnsubmit" value="Import">
                                                    <!--
                                                    <a href="">Download Template for student upload</a>-->
                                                </div>
                                            </form>
                                        </div>
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