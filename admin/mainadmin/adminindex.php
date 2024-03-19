<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
$stmt=$pdo->query("select * from student");
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$studentcount=$stmt->rowcount();

$stmt=$pdo->query("select * from department");
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$staffcount = $stmt->rowcount();

$stmt=$pdo->query("select * from request");
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$reqcount=$stmt->rowcount();


$stmt = $pdo->query("SELECT s.serv_name, COUNT(*) AS serv_name_count FROM service s JOIN request r ON r.serv_id = s.serv_id GROUP BY s.serv_name");
$rows1=$stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>admin-Dashboard</title>
</head>
<body>
    <?php include_once "../mainadmin/dashboard.php" ?>
    <div class="container-fluid">
        <div class="card-container">
            <div class="row">
              <div class="col">
                <div class="card" style="width: 18rem;">
                  <div class="card-body">
                      <h1 class="card-subtitle mb-2 text-body-secondary text-center"><i class='bx bxs-user'></i></h1>
                      
                      <h5 class="text-center"><?php echo $studentcount;  ?></h5>
                      <h5 class="card-title text-center text-secondary">Total Students</h5>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card" style="width: 18rem;">
                  <div class="card-body">
                      <h1 class="card-subtitle mb-2 text-body-secondary text-center"><i class='bx bxs-user'></i></h1> 
                      <h5 class="text-center"><?php echo $staffcount; ?></h5>
                      <h5 class="card-title text-center text-secondary">Total Staff</h5>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card" style="width: 18rem;">
                  <div class="card-body">
                      <h1 class="card-subtitle mb-2 text-body-secondary text-center"><i class='bx bxs-user'></i></h1>
                      <h5 class="text-center"><?php echo $reqcount; ?></h5>
                      <h5 class="card-title text-center text-secondary">Total Request</h5>
                  </div>
                </div>
              </div>
              </div>

                
                  <div class="row mt-5">
                    <div class="col">
                      <div class="card" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title text-center text-secondary">Number of Request</h5>
                          <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                              <?php
                              foreach ($rows1 as $row ){
                                echo '<tr>
                                <td colspan="12">'; echo $row["serv_name"];
                                echo'</td>';
                                echo '<td colspan="12">'; echo $row["serv_name_count"];
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
        
    </div>
   
  </body>
</html>