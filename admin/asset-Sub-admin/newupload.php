<?php
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php'; // !Load the database configuration file
$stmt=$pdo->query("SELECT sb.sub_a_id ,sb.sub_Fname, sb.sub_Lname , a.adm_name, d.dept_name ,sb.date_assign from sub_admin sb , department d ,admin a where d.dept_id= sb.dept_id and a.adm_id =sb.adm_id");
$rows= $stmt->fetchAll(PDO::FETCH_ASSOC);



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

        <!-- Data Table Start -->
        <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <!-- Data Table End-->
            

    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="../images/University_of_Technology_Mauritius_Logo.png" alt=""></i>University Of Technology, Mauritius
        </div>

        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <i class='bx bx-bell'></i>
            <img src="../images/home.png"  class="profile" />
        </div>
        
        </nav>  

    


        <!-- sidebar -->
        <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
            <div class="menu_title menu_dahsboard"></div>
            <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
            <!-- start -->
            <li class="item">
                <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                    <i class="bx bx-home-alt"></i>
                </span>
                <span class="navlink">Home</span>
                <i class="bx bx-chevron-right arrow-left"></i>
                </div>

                
            <!-- end -->

            <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
            <!-- start -->
            <li class="item">
                <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                    <i class="bx bx-grid-alt"></i>
                </span>
                <span class="navlink">Log In</span>
                <i class="bx bx-chevron-right arrow-left"></i>
                </div>

                <ul class="menu_items submenu">
                <a href="#" class="nav_link sublink">Admin</a>
                <a href="#" class="nav_link sublink">Student</a>
                <a href="#" class="nav_link sublink">Staffs</a>
                
                </ul>
            </li>
            <!-- end -->
            </ul>

            <ul class="menu_items">
            <div class="menu_title menu_editor"></div>
            <!-- duplicate these li tag if you want to add or remove navlink only -->
            <!-- Start -->
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bxs-magic-wand"></i>
                </span>
                <span class="navlink">Magic build</span>
                </a>
            </li>
            <!-- End -->

            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-loader-circle"></i>
                </span>
                <span class="navlink">Filters</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-filter"></i>
                </span>
                <span class="navlink">Filter</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-cloud-upload"></i>
                </span>
                <span class="navlink">Upload new</span>
                </a>
            </li>
            </ul>
            <ul class="menu_items">
            <div class="menu_title menu_setting"></div>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-flag"></i>
                </span>
                <span class="navlink">Notice board</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-medal"></i>
                </span>
                <span class="navlink">Award</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-cog"></i>
                </span>
                <span class="navlink">Setting</span>
                </a>
            </li>
            <li class="item">
                <a href="#" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-layer"></i>
                </span>
                <span class="navlink">Features</span>
                </a>
            </li>
            </ul>

            <!-- Sidebar Open / Close -->
            <div class="bottom_content">
            <div class="bottom expand_sidebar">
                <span> Expand</span>
                <i class='bx bx-log-in' ></i>
            </div>
            <div class="bottom collapse_sidebar">
                <span> Collapse</span>
                <i class='bx bx-log-out'></i>
            </div>
            </div>
        </div>
        </nav>

        <div class="container-fluid">
            <div class="card-container">
                <div class="row">
                    <div class="col">
                        <div class="card mb-3" style="width: 80rem;">
                            <h3 class="ms-3 mt-3 mb-4">New Student Upload</h3>
                            <div class="card-body">
                            <div class="col">
                                            <table class="table" id="ls">
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">Firstname</th>
                                                    <th scope="col">Surname</th>
                                                    <th scope="col">DOB</th>
                                                    <th scope="col">Umail</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Pin</th>
                                                    <th scope="col">Start Date</th>
                                                    <th scope="col">End Date</th>
                                                    <th scope="col">Mode</th>
                                                    <th scope="col">Cohort</th>
                                                    <th scope="col">Date Register</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    
                                                
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