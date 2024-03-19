<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file
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
    <link rel="stylesheet" href="../asset-Sub-admin/dashboard.css" />

          

  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="../images/UTM.png" alt=""></i>
      </div>

      

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        
        <i class='bx bx-bell'></i>
      
      </div>
      
    </nav>


    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          
          <li class="item">
            <a href="#" class="nav_link">
            <span class="navlink_icon">
            <i class='bx bxs-dashboard'></i>
            </span>
            <span class="navlink">Dashboard</span>
            </a>
        </li>
          <!-- start -->
          <li class="item">
            
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                    <i class="bx bx-user"></i> 
                </span>
                <span class="navlink">Manage Staff</span>
                <i class="bx bx-chevron-right arrow-left" style="padding-left:20px;"></i>
            </div>

            <ul class="menu_items submenu">
                <a href="../asset-Sub-admin/Mystaff.php" class="nav_link sublink">List Of Staff</a>
                <a href="../asset-Sub-admin/addstaff.php" class="nav_link sublink">Add New Staff</a>
            </ul>

          </li>


<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
            <i class="bx bx-book-add"></i> 
        </span>
        <span class="navlink">Manage Request</span>
        <i class="bx bx-chevron-right arrow-left"></i>
    </div>

    <ul class="menu_items submenu">
        <a href="../asset-Sub-admin/RequestHandle.php" class="nav_link sublink">All Request</a>
    </ul>
</li>




<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
          <i class='bx bxs-user-rectangle'></i>
        </span>
        <span class="navlink">Manage Student</span>
        <i class="bx bx-chevron-right arrow-left "></i>
    </div>

    <ul class="menu_items submenu">
      <a href="../asset-Sub-admin/addstudent.php" class="nav_link sublink">Add New Student</a>
      <a href="../asset-Sub-admin/AllStudent.php" class="nav_link sublink">List Student</a>
    </ul>
</li>
<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
          <i class='bx bxs-user-rectangle'></i>
        </span>
        <span class="navlink">Manage PC</span>
        <i class="bx bx-chevron-right arrow-left p"></i>
    </div>

    <ul class="menu_items submenu">
      <a href="../asset-Sub-admin/AddpC.php" class="nav_link sublink">Change PC</a>
     
    </ul>
</li>
<!--
        <li class="item">
            <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bx-cog' style='color:gray' ></i>
                </span>
                <span class="navlink">Setting</span>
                <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
                <a href="#" class="nav_link sublink">Change Details</a>
                <a href="#" class="nav_link sublink">Change Password</a>
            </ul>
        </li>-->


          <li class="item">
            <a href="../login-Asset/adminlogout.php" class="nav_link">
            <span class="navlink_icon">
                <i class="bx bx-exit"></i>
            </span>
            <span class="navlink">Log Out</span>
            </a>
        </li>
          <!-- end -->
        </ul>

        
        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          
          <?php
              $sql_subadm = "SELECT CONCAT(sub_Fname ,' ',sub_Lname)AS FN FROM sub_admin WHERE 	sub_a_id  = :id";
              $stmt_subadm = $pdo->prepare($sql_subadm);
              $stmt_subadm->execute(array(':id'=>$_SESSION["id"]));
              $datarow = $stmt_subadm->fetch(PDO::FETCH_ASSOC);
          ?>
          <div class="bottom collapse_sidebar">
            <span> <?php echo $datarow["FN"];  ?></span>
            <i class='bx bxs-user'></i>
          </div>
        </div>
      </div>
    </nav>
    
    


    
    <!-- JavaScript -->
    <script src="../asset-Sub-admin/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>