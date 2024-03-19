<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

if(!isset($_SESSION["rid"] )){
    header("Location: ../Login/staff_login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--Boostrap Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- Add these links to include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Data Table End-->
    <link rel="stylesheet" href="../Registry2/registry.css"/>
    

</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
    
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
                <a href="">
                    <img src="/miniproject/images/utm.png">
                    
                </a>
                <h1 class="text-secondary" style="margin-left:370px;">REGISTRY DEPARTMENT</h1>
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            
            <i class='bx bx-bell'></i>

        </div>
    
        
    

    </nav>

    

    <!--
    <div class="box-container">

        <div class="box box1 box-a" data-service="Testimonial">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Testimonials</h2>
            </div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png" alt="Views">
        </div>

        <div class="box box2 box-b" data-service="Transcript">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Transcripts</h2>
            </div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png" alt="Views">
        </div>

        <div class="box box3 box-c" data-service="Refund Of Fees">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Refund Of Fees</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(32).png" alt="comments">
        </div>

        <div class="box box4 box-d" data-service="Interruption">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Interruption</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>

        <div class="box box4 box-e" data-service="Change Mode of Study">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Change Mode of Study</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>


        <div class="box box4 box-f" data-service="Resumption">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Resumption</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>


        <div class="box box4 box-g" data-service=Withdrawal">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Withdrawal</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>

        <div class="box box4 box-h" data-service="Extention Of Dissertation">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Extention Of Dissertation</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>

        <div class="box box4 box-i" data-service="lost certificate">
            <div class="text">
                <h2 class="topic-heading"></h2>
                <h2 class="topic">Lost certificate</h2>
            </div>

            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
        </div>



    </div>
-->

    <!-- sidebar -->
    <nav class="sidebar" >
        <ul class="menu_items">
            <div class="menu_title menu_dashboard">
            
                <li class="item">
                    <a href="../Registry2/RegistryIndex.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-bar-chart-alt"></i>
                        </span>
                        <span class="navlink">Dashboard</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../Registry2/newrequest.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class='bx bxs-file-plus'></i>
                        </span>
                        <span class="navlink">New Request</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../Registry2/RegistryHistory.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-history"></i>
                        </span>
                        <span class="navlink">Request History</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../Registry2/changePassword.php" class="nav_link">
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

            </div>
        </ul>
        <?php   
            $stmtFN=$pdo->prepare("SELECT CONCAT(r_lname, ' ', r_fname) AS FN FROM registry where  r_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["rid"]));
            $rowFN=$stmtFN->fetch(PDO::FETCH_ASSOC);


        ?>
            
        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span><?php echo htmlspecialchars($rowFN["FN"])?></span>
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </nav>
    <!-- end -->

    <!-- JavaScript -->
    <script src="/client/script.js"></script>
    <script src="home.js"></script>
</body>

</html>