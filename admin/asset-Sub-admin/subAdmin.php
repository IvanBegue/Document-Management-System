    <?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file
    $error1=$error2=$error3=$error4='';
    if(isset($_POST['btnadd'])){
        try{
            $fn=validate_input($_POST['fn']);
            $ln=validate_input($_POST['ln']);
            $pdw=validate_input($_POST['pwd']);
            $dept=($_POST['dept']);
            $pn=$_POST["pin"];

            //* INSERT STATEMENT

            //TODO:Validation Missing
            $sql="INSERT INTO sub_admin (sub_Fname,sub_Lname,dept_id,sub_a_pin,sub_a_pwd) values(:fn,:ln,:dt,:pin,:pwd)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute(array(
                                ':fn'=>$fn,
                                ':ln'=>$ln,
                                ':dt'=>$dept,
                                ':pin'=>$pn,
                                ':pwd'=>$pdw
            ));
            header("location:allsubadmin.php");

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
        <!--Boostrap Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <title>Document Management System</title>
        <link rel="stylesheet" href="../asset-Sub-admin/subAdmin.css" />

            

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
                        
                        <div class="card mb-3" style="width: 60rem;">
                            <h3 class="ms-3 mt-3 mb-4">Manage Sub Admin</h3>
                            <div class="card-body">
                                
                                    <form class="row g-3" method="post" >
                                        <div class="col-md-4">
                                            <label class="form-label">Firstname</label>
                                            <input type="text" name="fn" class="form-control" >
                                            <span class="text-danger m-2"><?php echo $error1 ?></span>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Lastname</label>
                                            <input type="text" name="ln" class="form-control">
                                            <span class="text-danger m-2"><?php echo $error2 ?></span>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label  class="form-label">Department</label>
                                            <select name="dept" class="form-select">
                                                <option selected>Choose Department</option>
                                                <?php   
                                                    $sql1=$pdo->query("select * from department order by dept_name asc");
                                                    foreach($sql1 as $row){
                                                        echo "<option value='" . $row['dept_id'] . "'>" . $row['dept_name'] .
                                                                "</option>";
                                                    }

                                                ?>
                                                
                                            </select>
                                            <span class="text-danger m-2"><?php echo $error3   ?></span>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Access Pin</label>
                                            <input type="text" name="pin" class="form-control" >
                                                    
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Password</label>
                                            <input type="Password" name="pwd" class="form-control" >
                                            <span class="text-danger m-2"><?php echo $error4 ?></span>
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