<?php
session_start();
require_once 'c:/xampp/htdocs/MiniProject/db/pdo.php';

if (!isset($_SESSION['hid'])) {
    
    header("Location: ../Login/staff_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $_SESSION['hid'] = 12345;
      //tire sa la haut si to process login p marcher
        // Get the data from the form
        $pc_lname = $_POST['pc_lname'];
        $pc_fname = $_POST['pc_fname'];
        $pc_umail = $_POST['pc_umail'];
        $pc_adress = $_POST['pc_adress'];
        $pc_pin = $_POST['pc_pin'];
        $pc_password = $_POST['pc_password'];
        $pc_mobile = $_POST['pc_mobile'];
        $date_assign = $_POST['date_assign'];
        $hid = $_POST['hid']; // Assuming you have this field as a hidden input

        // Create the SQL statement
        $sql = "INSERT INTO `program_coordinator`(`pc_lname`, `pc_fname`, `pc_umail`, `pc_adress`, `pc_pin`, `pc_password`, `pc_mobile`, `date_assign`, `Hos_id`) VALUES  (:pc_lname, :pc_fname, :pc_umail, :pc_adress, :pc_pin, :pc_password, :pc_mobile, :date_assign, :hid)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':pc_lname', $pc_lname);
        $stmt->bindParam(':pc_fname', $pc_fname);
        $stmt->bindParam(':pc_umail', $pc_umail);
        $stmt->bindParam(':pc_adress', $pc_adress);
        $stmt->bindParam(':pc_pin', $pc_pin);
        $stmt->bindParam(':pc_password', $pc_password);
        $stmt->bindParam(':pc_mobile', $pc_mobile);
        $stmt->bindParam(':date_assign', $date_assign);
        $stmt->bindParam(':hid', $hid);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Record inserted successfully
            echo "PC record inserted successfully!";
        } else {
            // Handle errors if the insertion fails
            echo "Error inserting PC record.";
        }
    } catch (PDOException $e) {
        // Handle any exceptions
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle non-POST requests (optional)
    echo "Invalid request method.";
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
        <title>Head of School</title>
        <link rel="stylesheet" href="../hos/hos_history.css" />


        <!-- Data Table Start -->
        <!-- Add these links to include DataTables CSS and JavaScript -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script  src="https://code.jquery.com/jquery-3.5.1.js"></script>
        

        <script  src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <style>
        /* Style the form container */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        /* Style form labels */
        label {
            display: block;
            margin-bottom: 5px;
        }

        /* Style form inputs */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style the submit button */
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Change submit button color on hover */
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    </head>
    <body>
        <!-- navbar -->
        <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="../hos/images/UTM.png" alt="Description of the image"></i>
        </div>

        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <i class='bx bx-bell'></i>
            <a href="../hos/hos_pass.php"> <!-- Add the URL you want to navigate to -->
          <img src="../hos/images/avatar.jpg" alt=""></i>
      </a>
        </div>
        
        </nav> 

        <header>
  <h1>Head Of School</h1>
</div>
</header>
<form action="hos_pcacc.php" method="POST">
            <label for="pc_lname">Last Name:</label>
            <input type="text" id="pc_lname" name="pc_lname">
            <br>

            <label for="pc_fname">First Name:</label>
            <input type="text" id="pc_fname" name="pc_fname">
            <br>

            <label for="pc_umail">Email:</label>
            <input type="email" id="pc_umail" name="pc_umail">
            <br>

            <label for="pc_adress">Address:</label>
            <input type="text" id="pc_adress" name="pc_adress">
            <br>

            <label for="pc_pin">PIN:</label>
            <input type="text" id="pc_pin" name="pc_pin">
            <br>

            <label for="pc_password">Password:</label>
            <input type="password" id="pc_password" name="pc_password">
            <br>

            <label for="pc_mobile">Mobile:</label>
            <input type="tel" id="pc_mobile" name="pc_mobile">
            <br>

            <label for="date_assign">Date Assigned:</label>
            <input type="text" id="date_assign" name="date_assign" value="<?= date('Y-m-d'); ?>" readonly>

            <br>

            <!-- Assuming you have a hidden field for Hos_id with the value stored in the session -->
            <input type="hidden" id="Hos_id" name="Hos_id" value="<?php echo $_SESSION['hid']; ?>">
            
            <input type="submit" value="Submit">
        </form>
</div>
</div>
</div>




<!-- sidebar -->
<nav class="sidebar">
    <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <!-- start -->
        <li class="item">
            <a href="./hos_dash.php" class="nav_link">
                <span class="navlink_icon">
                    <i class="bx bx-bar-chart-alt"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
        <li class="item">
                <a href="./hos_history.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>
            <li class="item">
    <a href="./hos_pcacc.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-cog"></i>
        </span>
        <span class="navlink">Create Pc Account</span>
    </a>
</li>
            <li class="item">
    <a href="./hos_pass.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-cog"></i>
        </span>
        <span class="navlink">Change Password</span>
    </a>
</li>
  <li class="item">
    <a href="http://localhost:8080/MiniProject/hos/logout.php" class="nav_link">
        <span class="navlink_icon">
            <i class="bx bx-exit"></i>
        </span>
        <span class="navlink">Log Out</span>
    </a>
</li>
 
        <!-- end -->
    </ul>

    </ul>

    <?php  
    $_SESSION['hid'] = 12345; 
            $stmtFN=$pdo->prepare("SELECT CONCAT(hos_lname, ' ', hos_fname) AS FN FROM hos where  hos_id= :id");
            $stmtFN->execute(array(":id"=> $_SESSION["hid"]));
            $rowFN=$stmtFN->fetch(PDO::FETCH_ASSOC);


        ?>
            
        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span><?php echo htmlspecialchars($rowFN["FN"])?></span>
                <i class='bx bxs-user'></i>
            </div>
        </div>
    </nav>


<!-- JavaScript -->
<script src="/client/script.js"></script>
<script src="home.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (event) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="date"]');

            for (const input of inputs) {
                if (input.value.trim() === '') {
                    alert('Please fill in all fields.');
                    event.preventDefault();
                    return;
                }
            }
        });
    });
</script>
</body>
</html>