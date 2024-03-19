

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
    <link rel="stylesheet" href="../client/template.css" />


    <!-- Data Table Start -->
    <!-- Add these links to include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>


    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>



    <!-- Data Table End-->


</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <a href="../finance/finance_dash.php">
                <img src="images/UTM.png" alt="Description of the image"></i>
            </a>
        </div>


        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <i class='bx bx-bell'></i>
            <a href="../finance/finance_pass.php"> <!-- Add the URL you want to navigate to -->
                <img src="../finance/images/avatar.jpg" alt=""></i>
            </a>
        </div>

    </nav>

    <header>
        <h1>Finance Department</h1>
    </header>


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

    <div class="report-container">
        <div class="report-header">
            <h1 class="recent-Articles">Recent Articles</h1>
            <button class="view" onclick="refreshPage()">View All</button>
        </div>



        <table id="myTable" class="display">

            <thead>
                <tr class="header">
                    <th style="width:15%;">Student Id</th>
                    <th style="width:20%;">Student Name</th>
                    <th style="width:15%;">Request Name</th>
                    <th style="width:15%;">Date</th>
                    <th style="width:15%;">Status</th>
                    <th style="width:30%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the data array and populate the table rows
                foreach ($data as $row) {
                    echo '<tr>';
                    echo '<td style="text-align: center;"><a href="finance_viewform.php?req_id=' . $row['req_id'] . '" style="color: black;">' . htmlspecialchars($row['s_id']) . '</a></td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['student_name']) . '</td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['serv_name']) . '</td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['req_date']) . '</td>';
                    echo '<td style="text-align: center;">' . htmlspecialchars($row['status']) . '</td>';
                    echo '<td style="text-align: center;">';
                    echo '<form method="POST" action=processClearance.php>';
                    echo '<button class="approve-button" name="btnapprove" value="' . $row['req_id'] . '">Approve</button>';
                    echo '<button class="decline-button" name="btndel"  value="' . $row['f_process_id'] . '"  onclick="showPopup()">Decline</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <p style="text-align: center; margin-top: 10px;">Click on the Student ID to view the form</p>

        <script>
          

            // Get all box containers
            const boxContainers = document.querySelectorAll('.box');

            // Add click event listener to each box container
            boxContainers.forEach(function(box) {
                box.addEventListener('click', function() {
                    // Retrieve the service name from the data-service attribute
                    const serviceName = box.getAttribute('data-service');

                    // Filter the table to show only rows with the selected service name
                    filterTableByService(serviceName);
                });
            });

            // Function to filter the table by service name
            function filterTableByService(serviceName) {
                const tableRows = document.querySelectorAll('#myTable tbody tr');

                // Loop through all table rows
                tableRows.forEach(function(row) {
                    // Check if the row contains the selected service name
                    const cell = row.querySelector('td:nth-child(3)'); // Assuming service name is in the second column
                    if (cell) {
                        const cellText = cell.textContent || cell.innerText;
                        if (cellText === serviceName) {
                            // Show the row
                            row.style.display = '';
                        } else {
                            // Hide the row
                            row.style.display = 'none';
                        }
                    }
                });
            }


            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>

    </div>
    </div>
    </div>




    <!-- sidebar -->
    <nav class="sidebar">
        <ul class="menu_items">
            <div class="menu_title menu_dashboard"></div>
            <!-- start -->
            <li class="item">
                <a href="../finance/finance_dash.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-bar-chart-alt"></i>
                    </span>
                    <span class="navlink">Dashboard</span>
                </a>
            </li>

            <li class="item">
                <a href="../finance/financeHistory.php" class="nav_link">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>


            <li class="item">
                <a href="http://localhost/MiniProject/log-in/staff_login.php" class="nav_link">
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
            <div class="bottom expand_sidebar">
                <span> Expand</span>
                <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
                <span> Collapse</span>
                <i class='bx bx-log-out'></i>
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