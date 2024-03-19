<?php
/*
$aid=$_SESSION["id"];
function getName($aid){
  global $pdo;
  $sql=$pdo->prepare("SELECT adm_name FROM admin where adm_id=:id");
  $sql->execute(array(":id"=>$aid));
  $adrow=$sql->fetch(PDO::FETCH_ASSOC);
  $name=$adrow["adm_name"];
  return  $name;

}*/


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

    <link rel="stylesheet" href="../mainadmin/dashboard.css" />

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
            <a href="../mainadmin/adminindex.php" class="nav_link">
            <span class="navlink_icon">
            <i class='bx bxs-dashboard'></i>
            </span>
            <span class="navlink">Dashboard</span>
            </a>
        </li>
          
            
          <!-- start -->
          <li class="item">
            <div class="nav_link submenu_item">
                <span class="navlink_icon">
                    <i class="bx bx-user"></i> 
                </span>
                <span class="navlink">Sub Admin</span>
                <i class="bx bx-chevron-right arrow-left bx-sm"></i>
            </div>

            <ul class="menu_items submenu">
                <a href="#" class="nav_link sublink">List Of Staff</a>
                <a href="#" class="nav_link sublink">Add New Staff</a>
            </ul>

          </li>


<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
            <i class="bx bx-book-add"></i> 
        </span>
        <span class="navlink">Programme</span>
        <i class="bx bx-chevron-right arrow-left bx-sm"></i>
    </div>

    <ul class="menu_items submenu">
        <a href="../mainadmin/program.php" class="nav_link sublink">Add Program</a>
    </ul>
</li>




<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
          <i class='bx bxs-user-rectangle'></i>
        </span>
        <span class="navlink">Cohort</span>
        <i class="bx bx-chevron-right arrow-left bx-sm"></i>
    </div>

    <ul class="menu_items submenu">
      <a href="../mainadmin/cohort.php" class="nav_link sublink">Add Cohort</a>
     
    </ul>
</li>
<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
          <i class='bx bxs-user-rectangle'></i>
        </span>
        <span class="navlink">Services</span>
        <i class="bx bx-chevron-right arrow-left bx-sm"></i>
    </div>

    <ul class="menu_items submenu">
      <a href="../mainadmin/services.php" class="nav_link sublink">Add Service</a>
     
    </ul>
</li>
<li class="item">
    <div href="#" class="nav_link submenu_item">
        <span class="navlink_icon">
          <i class='bx bxs-group'></i>
        </span>
        <span class="navlink">Student</span>
        <i class="bx bx-chevron-right arrow-left bx-sm"></i>
    </div>

    <ul class="menu_items submenu">
      <a href="../mainadmin/liststudent.php" class="nav_link sublink">List Students</a>
     
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
            <a href="../login-Asset/admin_logout.php" class="nav_link">
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
          
        
         
          <div class="bottom collapse_sidebar">
            <span><?php 
            //$name=getName($aid);
            //echo $name?> </span>
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