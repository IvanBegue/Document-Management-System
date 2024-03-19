<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration filele
if(!isset($_SESSION["id"])){
    header("location:  ../login-Asset/adminlogin.php");
}
$stmt=$pdo->query("SELECT s.s_id,s.s_pin , s.s_fname , s.s_lname, c.cohort_name ,p.prog_name, sch.School_acronym ,st.us_name from student s , cohort c , program_coordinator pc, programme p, school sch ,user_status st where s.cohort_id=c.cohort_id AND c.prog_id=p.prog_id AND p.school_id=sch.school_ID AND s.us_id=st.us_id;");
$rows= $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
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
                            <h3 class="ms-3 mt-3 mb-4 fw-semibold">List of Students</h3>
                            <div class="card-body">
                            <div class="col">
                                            <table class="table table-hover" id="ls">
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">StudentID</th>
                                                    <th scope="col">Firstname</th>
                                                    <th scope="col">Lastname</th>
                                                    <th scope="col">Cohort</th>
                                                    <th scope="col">Course Enrolled</th>
                                                    <th scope="col">School</th>
                                                    <th scope="col">Account Status</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    if ($rows) {
                                                        foreach ($rows as $row) {
                                                            echo '<tr class="text-center">';
                                                            echo '<td>';
                                                            echo htmlspecialchars($row["s_pin"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["s_fname"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["s_lname"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["cohort_name"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["prog_name"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["School_acronym"]);
                                                            echo '</td><td>';
                                                            echo htmlspecialchars($row["us_name"]);
                                                            echo '</td><td>';
                                                            echo '<form method="GET" action="UpdateStatus.php">';
                                                            echo '<div class="dropdown">
                                                                    <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                                    </button>';
                                                            echo '<input type="hidden" name="q" value="'.htmlspecialchars($row["s_id"]) . '">';
                                                            //!ADD VALIDATION FOR disable button and enable button
                                                            echo '<ul class="dropdown-menu">
                                                                    <li><button class="dropdown-item" type="submit" name="btndsl">Disable</button></li>';
                                                                    echo '<li><button class="dropdown-item" type="submit" name="btnupt">Archive</button></li>';
                                                                echo '</ul>';
                                                            echo '</div>';
                                                            echo '</form>';
                                                            echo '</td></tr>';
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