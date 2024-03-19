<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if (!isset($_SESSION["rcid"])) {
    
    header("Location: ../Login/staff_login.php");
    
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
    
    <link rel="stylesheet" href="../finance/finance.css" />


    <!-- Data Table Start -->
    <!-- Add these links to include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <a href="../resouce_center/rc_dash.php">
                <img src="images/UTM.png" alt="Description of the image"></i>
            </a>
            <h1 class="text-secondary" style="margin-left:370px;">RESOURCE CENTER DEPARTMENT</h1>
        </div>

        

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-bell'></i>
        </div>
    </nav>

    <nav class="sidebar">
        <ul class="menu_items">
            <div class="menu_title menu_dashboard"></div>
        
            <li class="item">
                <a href="../resouce_center/rcindex.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-bar-chart-alt"></i>
                    </span>
                    <span class="navlink">Dashboard</span>
                </a>
            </li>
            <li class="item">
                <a href="../resouce_center/rcHistory.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>
            <li class="item">
                <a href="../resouce_center/rc_pass.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-cog"></i>
                    </span>
                    <span class="navlink">Change Password</span>
                </a>
            </li>
            <li class="item">
                <a href="../Login/logout.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-exit"></i>
                    </span>
                    <span class="navlink">Log Out</span>
                </a>
            </li>
        </ul>

        <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(rc_lname, ' ', rc_fname) AS FN FROM resource_center where  rc_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["rcid"]));
            $rowFN=$stmtFN->fetch(PDO::FETCH_ASSOC);
        ?>

        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span><?php echo htmlspecialchars($rowFN["FN"])?></span>
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </nav>
    

    
    <script src="/client/script.js"></script>
    <script src="home.js"></script>
</body>

</html>
