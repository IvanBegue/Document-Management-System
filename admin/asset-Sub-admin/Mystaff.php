<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file

if(!isset($_SESSION["id"])){
    header("location:  ../login-Asset/adminlogin.php");
}
$stmt=$pdo->query("SELECT r_lname, r_fname, r_umail, date_assign FROM registry;");
$rows= $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <!--navbar-->

        <div class="container-fluid">
            <div class="card-container">
                <div class="row">
                    <div class="col">
                        <div class="card mb-3" style="width: 60rem;">
                            <h3 class="ms-3 mt-3 mb-4 fw-semibold">All Staff in Registry Department</h3>
                            <div class="card-body">
                            <div class="col">
                                            <table class="table" id="ls">
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">Lastname</th>
                                                    <th scope="col">Firstname</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Date Created</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($rows as $row){
                                                            $newdate=strtotime($row['date_assign']); 
                                                            
                                                            echo '<tr  class="text-center">';
                                                            echo '<td>';
                                                            echo $row['r_lname'];
                                                            echo '</td><td>';
                                                            echo $row['r_fname'];
                                                            echo '</td><td>';

                                                            
                                                            echo $row['r_umail'];
                                                            echo '</td><td>';
                                                            echo date('d/m/Y',$newdate); 
                                                            echo '</td><td>';
                                                            echo '<form method="post" action="UpdateSubAdmin.php?subid=">';
                                                            echo '<div class="dropdown">
                                                            <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                                            </button>';
                                                            echo ' <ul class="dropdown-menu">
                                                            <li><button class="dropdown-item" type="button" name="btndel">Disable</button></li>
                                                            <li><button class="dropdown-item" type="button" name="btnupt">Update</button></li>
                                                            </ul>';
                                                            echo '</div>';
                                                            echo '</form>';
                                                            echo '</td></tr>';

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
            
        </div>

        

        <!-- JavaScript -->
        <script src="/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <!-- For DATATABLE START HERE-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script>
                $(document).ready(function () {
                    $('#ls').DataTable({
                        "lengthMenu": [2, 3, 5, 10, 20],
                        lengthChange: true,
                        info: true,
                        pageLength: 5,
                        
                        "dom": '<"search"f>t<"bottom"lip>'

                        
                    });
                    
                });
            </script>
        <!-- For DATATABLE START END-->
    </body>
    </html>