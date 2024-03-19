<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file

if(!isset($_SESSION["id"])){
    header("location:  ../login-Asset/adminlogin.php");
}


function getfinanceProcessData(){
    global $pdo;
    $stmt=$pdo->query("SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StundentName ,s.s_pin AS PIN,c.cohort_name AS COHORT, sv.serv_name AS SERVICE,fp.date_process AS DATE,st.status AS STATUS, CONCAT(f.f_fname,' ',f.f_lname) AS Name from student s,finance_process fp, request r , status st,service sv,cohort c,finance f where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND fp.status_id=st.status_id AND fp.req_id=r.req_id AND fp.f_id=f.f_id AND fp.date_process IS NOT NULL");
    //$rows 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getacademicUnitProcessData(){
    global $pdo;
    $stmt="SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StundentName , s.s_pin AS PIN, c.cohort_name AS COHORT, sv.serv_name AS SERVICE, ap.date_process AS DATE,st.status AS STATUS, CONCAT(a.acu_fname,' ',a.acu_lname) AS Name from student s,ac_process ap, request r , status st,service sv,cohort c,academic_unit a where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND ap.status_id=st.status_id AND ap.req_id=r.req_id AND ap.acu_id=a.acu_id AND ap.date_process IS NOT NULL";

    //$rows 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDcprocessData(){
    global $pdo;
    $stmt="SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StundentName , s.s_pin AS PIN, c.cohort_name AS COHORT, sv.serv_name AS SERVICE, dc.date_process AS DATE,st.status AS STATUS, CONCAT(d.dc_lname,' ',d.dc_fname) AS Name from student s,dc_process dc, request r , status st,service sv,cohort c,disertation_commitee d where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND dc.status_id=st.status_id AND dc.req_id=r.req_id AND dc.dc_id=d.dc_id AND dc.date_process IS NOT NULL";
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getExamUnitProcessData(){
    global $pdo;
    $stmt="SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StundentName , s.s_pin AS PIN, c.cohort_name AS COHORT, sv.serv_name AS SERVICE, ep.date_process AS DATE,st.status AS STATUS, CONCAT(e.eu_lname,' ',e.eu_fname) AS Name from student s,exam_unit_process ep, request r , status st,service sv,cohort c,exam_unit e where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND ep.status_id=st.status_id AND ep.req_id=r.req_id AND ep.eu_id =e.eu_id AND ep.date_process IS NOT NULL";

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRcProcessData(){
    global $pdo;

    $stmt="SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StundentName , s.s_pin AS PIN, c.cohort_name AS COHORT, sv.serv_name AS SERVICE,rcp.date_process AS DATE,st.status AS STATUS, CONCAT(rc.rc_lname,' ',rc.rc_fname) AS Name from student s,rc_process rcp, request r , status st,service sv,cohort c,resource_center rc where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND rcp.status_id=st.status_id AND rcp.req_id=r.req_id AND rcp.rc_id=rc.rc_id AND rcp.date_process IS NOT NULL";

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRegistryProcessData(){
    global $pdo;

    $stmt=$pdo->query("SELECT CONCAT(s.s_fname,' ',s.s_lname) AS StudentName , s.s_pin AS PIN, c.cohort_name AS COHORT, sv.serv_name AS SERVICE,rp.date_process AS DATE,st.status AS STATUS, CONCAT(rg.r_lname,' ',rg.r_fname) AS Name from student s,registry_process rp, request r , status st,service sv,cohort c, registry rg where r.s_id=s.s_id AND s.cohort_id=c.cohort_id AND R.serv_id=sv.serv_id AND rp.status_id=st.status_id AND rp.req_id=r.req_id AND rp.r_id=rg.r_id AND rp.date_process IS NOT NULL");

    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <div class="card mb-3" style="width: 80rem;">
                            <h3 class="ms-3 mt-3 mb-4 fw-semibold">All Request Process By Registry Department</h3>
                            <div class="card-body">
                            <div class="col">
                                            <table class="table table-hover" id="ls">
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">Student Name</th>
                                                    <th scope="col">Student ID</th>
                                                    <th scope="col">Student Cohort</th>
                                                    <th scope="col">Request</th>
                                                    <th scope="col">Request Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Process By</th>
                                                
                                                    
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $rows=getRegistryProcessData();
                                                if($rows){
                                                    foreach ($rows as $row) {
                                                        echo '<tr>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['StudentName']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['PIN']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['COHORT']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['SERVICE']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['DATE']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['STATUS']) . '</td>';
                                                        echo '<td class="text-center">' . htmlspecialchars($row['Name']) . '</td>';
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