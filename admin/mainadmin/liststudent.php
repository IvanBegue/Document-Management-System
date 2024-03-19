<?php
session_start();
if(!isset( $_SESSION["id"])){
    header("location ../login-Asset/adminlogin.php");
}
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; 
$stmt = $pdo->query("SELECT  s.s_fname, s.s_lname,s.S_Pin,s.s_umail,p.prog_name ,s.date_Register,c.cohort_name,s.us_id from student s , programme p , cohort c  where c.cohort_id= s.cohort_id and c.prog_id = p.prog_id ");
$rows= $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title></title>
    <link rel="stylesheet" href="../viewStudent-Asset/liststudent.css" />
   
</head>
<body>

<?php include_once "../mainadmin/dashboard.php" ?>
        
        <div class="container-fluid">
            <div class="card-container">
                <div class="row">
                    <div class="col">
                        
                        <div class="card mb-3" style="width: 80rem;">
                            <h3 class="ms-3 mt-3 mb-4">All Student Data</h3>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col">
                                            <table class="table" id="ls">
                                                <thead>
                                                <tr class="text-center">

                                                    <th scope="col">Firstname</th>
                                                    <th scope="col">Surname</th>
                                                    <th scope="col">Student ID</th>
                                                    <th scope="col">Umail</th>
                                                    <th scope="col">Program Enroll</th>
                                                    <th scope="col">Added Date</th>
                                                    <th scope="col">Cohort</th>
                                                    <th scope="col">Account Status</th>
                                                    
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($rows as $row){
                                                            $timestamp=strtotime($row['date_Register']);
                                                            $dateformat=date("d/m/Y",$timestamp);
                                                            echo '<tr  class="text-center">';
                                                            echo ' <td>';
                                                        
                                                            echo ($row['s_fname']);
                                                            echo '</td><td>';
                                                            echo ($row['s_lname']);
                                                            echo '</td><td>';
                                                            echo  ($row['S_Pin']);
                                                            echo '</td><td>';
                                                            echo ($row['s_umail']);
                                                            echo '</td><td>';
                                                            echo ($row['prog_name']);
                                                            echo '</td><td>';
                                                            echo ($dateformat);
                                                            echo '</td><td>';
                                                            echo ($row['cohort_name']);
                                                            echo '</td><td>';
                                                            if ($row['us_id']==1){
                                                                echo '<button type="button" class="btn btn-success btn-sm">Active</button></td>';
                                                            
                                                            echo '</tr>';
                                                            } elseif ($row['us_id']==2){
                                                                echo '<button type="button" class="btn btn-danger btn-sm">Block</button></td>';
                                                                echo '<td>';
                                                            
                                                            echo '</tr>';
                                                            } else {
                                                                echo '<button type="button" class="btn btn-warning btn-sm">Archieve</button></td>';
                                                            
                                                                echo '</tr>';
                                                            }
                                                            
                                                            
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
            
        </div>
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