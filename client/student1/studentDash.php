<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

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
        <link rel="stylesheet" href="../student1/student.css">
        <!-- Data Table Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
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
                <img src="../finance/images/UTM.png" alt="Description of the image"></i>
            </div>

            
            
            <div class="navbar_content">
                <i class="bi bi-grid"></i>

                
                <i class='bx bx-bell'></i>
            </div>
        
        </nav> 


<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="../student1/studentindex.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
        <li class="item">
            <a href="../student1/form.php" class="nav_link">
                <span class="navlink_icon">
                    <i class='bx bxs-file-plus'></i>
                </span>
                <span class="navlink">Fill Form</span>
            </a>
        </li>
        <li class="item">
            <a href="../student1/studentHistory.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-history"></i>
                </span>
                <span class="navlink">Request History</span>
            </a>
        </li>
        <li class="item">
            <a href="../student1/studentPass.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-cog"></i>
                </span>
                <span class="navlink">Changed Password</span>
            </a>
        </li>
        <li class="item">
            <a href="../student1/myprofil.php"  class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bxs-user"></i>
                </span>
                <span class="navlink">My Profil</span>
            </a>
        </li>
        <li class="item">
            <a href="../login/logout.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-exit"></i>
                </span>
                <span class="navlink">Log Out</span>
            </a>
        </li>
        
    </ul>
    <!-- Sidebar Open / Close -->
        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
            <?php 
    if(isset($_SESSION["sid"])){
        $selectFN=$pdo->prepare("SELECT CONCAT(s_lname,' ' ,s_fname)as FN FROM student where s_id =:id");
        $selectFN->execute(array(":id"=>$_SESSION["sid"]));
        $datafn=$selectFN->fetch(PDO::FETCH_ASSOC);
        echo '<span class="text-capitalize"> ' .htmlspecialchars($datafn["FN"]). '</span>';
    }

    ?>
        <i class='bx bxs-user'></i>
        </div>
    </div>
</nav>
<script>
    function myFunction() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>

<!-- JavaScript -->
<script src="/client/script.js"></script>
<script src="home.js"></script>
</body>
</html>