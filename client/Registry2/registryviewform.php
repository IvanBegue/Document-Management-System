<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";

require_once $_SERVER["DOCUMENT_ROOT"]."./MiniProject/db/util.php";


if(!isset($_SESSION["rid"])){
    header("Location: ../Login/staff_login.php");
}
$id=$_GET["q"];

if(isset($id)){
    try{
      //$statusRow=false;
      //*Selecting Information for the forms
    $stmt=$pdo->prepare("SELECT CONCAT(s.s_lname,' ' ,s.s_fname) AS fn, s.s_umail,r.req_details, s.s_pin,s.s_mobile,s.s_address,c.cohort_name,p.prog_name,s.s_mode,sv.serv_name,r.req_date,sch.school_name ,s.year , s.semester FROM request r , student s,cohort c,programme p,service sv,school sch where r.s_id=s.s_id and s.cohort_id=c.cohort_id and c.prog_id=p.prog_id and r.serv_id=sv.serv_id and p.school_id=sch.school_id and r.req_id= :id");
    $stmt->execute(array(':id'=>$id));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

    //*Selecting Status of the forms
    $status=$pdo->prepare("SELECT status_id from registry_process where req_id = :id");
    $status->execute(array(':id'=>$id));
    $statusRow=$status->fetch(PDO::FETCH_ASSOC);

    
    

    }catch(exception $e){
    error_log('Error: ' . $e->getMessage());
    }
}

if(!$row){
    header("location:../Registry2/RegistryIndex.php");
}
    
if(isset($_POST["btnsubmit"])){
  if (isset($_FILES["form"])&& $_FILES["form"]["error"] === UPLOAD_ERR_OK){
    $filename = $_FILES["form"]["name"];
      $uniqueFileName = uniqid('', true) . '_' . $filename;
      move_uploaded_file($_FILES["form"]["tmp_name"], "C:/xampp/htdocs/MiniProject/FormProcess/" . $uniqueFileName);
    // Update the status_id in registry_process
    $updateRegistryProcessSql = "UPDATE registry_process SET status_id = 4 WHERE req_id = :id";
    $updateRegistryProcessStmt = $pdo->prepare($updateRegistryProcessSql);
    $updateRegistryProcessStmt->execute(array(":id" => $id));

    // Update the status_id in request
    $updateRequestSql = "UPDATE request SET status_id = 6,Request_Forms=:fn WHERE req_id = :id";
    $updateRequestStmt = $pdo->prepare($updateRequestSql);
    $updateRequestStmt->execute(array(":id" => $id,":fn"=>$uniqueFileName));
    $em=$row["s_umail"];
        $sub="Document Management System Notification";
        $body="Dear Student, your form is ready to collect";
        $nm=" ";

        sendEmail($em,$sub,$body,$nm);
  } 
  header("location:../Registry2/RegistryIndex.php");
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Student Request Form</title>
    
</head>
<body>
<?php include_once "../Registry2/RegistryDashboard.php"; ?>

<style>
    
/* VIEW FORM START*/

.container {

max-width: 800px;
background: rgba(156, 152, 152, 0.71);
padding: 28px;
border-radius: 10px;
box-shadow: inset -2px 2px 2px white;

}
.form-title {
font-size: 26px;
font-weight: 600;
text-align: center;
padding-bottom: 6px;
color: white;
text-shadow: 2px 2px 2px black;
border-bottom: solid 1px white;
}

.main-user-info {
display: flex;
flex-wrap: wrap;
justify-content: space-between;
padding: 20px 0;
}

.user-input-box:nth-child(2n) {
justify-content: end;
}

.user-input-box {
display: flex;
flex-wrap: wrap;
width: 50%;
padding-bottom: 15px;
}

.user-input-box label {
width: 95%;
color: white;
font-size: 20px;
font-weight: 400;
margin: 5px 0;
}

.mb-3 {
width: 95%;
color: white;
font-size: 20px;
font-weight: 400;
margin: 5px 0;
}


.user-input-box input,
.user-input-box select {
height: 40px;
width: 95%;
border-radius: 7px;
outline: none;
border: 1px solid grey;
padding: 0 10px;
cursor: pointer;
}

.radio-buttons {
display: flex;
flex-wrap: wrap;
justify-content: space-between; /* Separate radio buttons to the left and right */
}

.radio-buttons .radio-left,
.radio-buttons .radio-right {
flex-basis: 48%; /* Adjust as needed to control the width of left and right sections */
}

.radio-buttons input[type="radio"] {
margin-right: 5px; /* Add some space between radio buttons */
height: 20px; /* Reduce the height of radio buttons */
width: 20px; /* Reduce the width of radio buttons */
cursor: pointer;
}



#description {
width: 100%;
padding: 40px;
border: 1px solid grey;
border-radius: 7px;
outline: none;
resize: vertical;
font-size: 16px;
margin-top: 10px;
box-sizing: border-box; /* Ensure padding and border are included in width */
}

/* Style for the file input label */
.form-label {
font-weight: bold;
margin-bottom: 0;
}

.input-group {
display: flex;
flex-direction: column;
margin-bottom: 20px; /* Add some spacing between input groups */
}

.input-label {
width: 95%;
color: white;
font-size: 20px;
font-weight: 400;
margin: 5px 0; /* Add some spacing between label and textarea */
}


/* CSS for styling the tick (checkmark) symbol */
buttons {
font-size: 30px; /* Adjust the size of the checkmark */
color: #000000; /* Change the color of the checkmark */
background-color:#a29d9d8c; /* Make the button background transparent */
border: none; /* Remove the button border */
cursor: pointer;
}

buttons:hover {
text-decoration: underline; /* Add an underline effect on hover (optional) */
}



/* Button Styles */
.button {
display: block; /* Change to block element to center it horizontally */
margin: 0 auto; /* Center horizontally by setting left and right margins to "auto" */
padding: 15px 50px;
font-size: 16px;
background-color: #000000; /* Button background color */
color: #fff; /* Text color */
border: none;
border-radius: 4px;
cursor: pointer;
transition: background-color 0.3s ease; /* Smooth transition for background color */
text-decoration: none; /* Remove underlines for links */
text-align: center;
}


/* Hover state */
.button:hover {
background-color: #0056b3; /* Darker background color on hover */
}

/* Active (clicked) state */
.button:active {
background-color: #003d80; /* Even darker background color on click */
}
.radio-buttons {
display: flex; /* Use flexbox to arrange radio buttons side by side */
flex-wrap: wrap; /* Wrap to the next line if the container overflows */
}

.radio-buttons input[type="radio"] {
margin-right: 10px; /* Add some space between radio buttons */
}


@media(max-width: 600px) {
.container {
    min-width: 280px;
}

.user-input-box {
    margin-bottom: 12px;
    width: 100%;
}

.user-input-box:nth-child(2n) {
    justify-content: space-between;
}



.main-user-info {
    max-height: 380px;
    overflow: auto;
}

.main-user-info::-webkit-scrollbar {
    width: 0;
}
}




/* Style for the file input */
.input-group input[type="file"] {
border: 1px solid #ccc; /* Border color */
padding: 10px;
width: 100%;
border-radius: 5px;
font-size: 16px;
color: #555; /* Text color for the input */
background-color: #fff; /* Background color */
transition: border-color 0.3s ease; /* Smooth transition for border color */
}

/* Style for the file input on hover */
.input-group input[type="file"]:hover {
border-color: #007BFF; /* Border color on hover */
cursor: pointer; /* Cursor style on hover */
}

/*VIEW FORM END*/
</style>

<div class="container me-5 mt-5">
    <h1 class="form-title">Student Request Form</h1>

    <div class="mb-3">
        <label for="schoolname">School Name</label>
        <input type="text" value="<?php echo $row["school_name"]?>" class="form-control" id="schoolname"   style="font-weight: bold; color: #555;" readonly>
    </div>
        <div class="main-user-info">
        <div class="user-input-box">
            <label for="fullName">Full Name</label>
            <input type="text"   value="<?php echo $row["fn"] ?>" readonly/>
        </div>
        


        <div class="user-input-box">
          <label for="username">Student ID</label>
          <input type="text"     value="<?php echo $row["s_pin"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="email">Email Address</label>
          <input type="email"   value="<?php echo $row["s_umail"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="phoneNumber">Phone Number</label>
          <input type="text"   value="<?php echo $row["s_mobile"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="residentialAddress">Residential Address</label>
          <input type="text"   value="<?php echo $row["s_address"] ?>" readonly/>
        </div>
        <div class="user-input-box">
          <label for="programme">Programme</label>
          <input type="text"   value="<?php echo $row["prog_name"] ?>" readonly/>
        </div>
        <div class="user-input-box">
            <label for="year">Year</label>
            <input type="text"  value="<?php echo $row["year"] ?>" readonly />
          </div>
      
      <div class="user-input-box">
        <label for="mode">Mode of Study</label>
        <input type="text"   value="<?php echo $row["s_mode"] ?>" readonly/>
      </div>
        

      
      <!-- Modify your request select element to include an onchange event -->
      <div class="user-input-box">
        <label for="request">Request</label>
        <input type="text"   value="<?php echo $row["serv_name"] ?>" readonly/>
      </div>
        
        

          <div class="user-input-box">
            <label for="cohort">Cohort</label>
            <input type="text"  value="<?php echo $row["cohort_name"] ?>" readonly />
          </div>
  
          <!-- Add a label for date with sysdate (current date) -->
          <div class="user-input-box">
            <label for="date">Date</label>
            <?php 
              $newDate=strtotime($row["req_date"] );


            ?>
            <input type="text"  value="<?php echo date('d/m/y',$newDate);?>" readonly/>
        </div>
        
  
          
        <div class="user-input-box">
            <label for="semester">Semester</label>
            <input type="text"  value="<?php echo $row["semester"] ?>" readonly/>
        </div>
        
      <div class="input-group">
        <label for="description" class="input-label">Detail of request</label>
        <textarea class="form-control" id="description" aria-label="With textarea"  readonly><?php echo($row["req_details"]) ?></textarea>
      </div>
      <?php
        try{
          if(($statusRow) && $statusRow["status_id"]==11){
            
            $stmt3=$pdo->prepare("select form  from  registry_process where req_id=:id");
            $stmt3->execute(array(':id'=>$id));
            $row3=$stmt3->fetch(PDO::FETCH_ASSOC);
            
            $documents = array($row3["form"]);
            
            echo '<div class="input-group">';
            foreach ($documents as $doc) {
                echo '<a class="btn btn-primary col-5" href="download.php?file=' . urlencode($doc) . '">Download Form</a>';
            }

          
            echo '</div>';
            echo ' <form method="POST" enctype="multipart/form-data">
            <input type="file" name="form" >
            <button type="submit"  name="btnsubmit" class="btn btn-primary col-12 mt-3">Send</button>
          </form>';
          }
        }catch(exception $e){
          error_log('Error: ' . $e->getMessage());
        }
      ?>
      </form>
          
            
        </div>
          <div >
            <a href="../Registry2/RegistryIndex.php" class="btn btn-primary">Back Home</a>
          </div>
    
    </div>
    
<script>
  document.getElementById("downloadButton").addEventListener("click", function() {
    // Send an AJAX request to a PHP script to fetch the image data
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_image.php", true);
    xhr.responseType = "blob"; // The response will be treated as a binary file
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Create a temporary URL for the blob
            var blob = new Blob([xhr.response], { type: "image/png" }); // Adjust the content type as needed
            var url = window.URL.createObjectURL(blob);

            // Create an anchor element and simulate a click to download the image
            var a = document.createElement("a");
            a.style.display = "none";
            a.href = url;
            a.download = "image.jpg"; // Specify the filename

            document.body.appendChild(a);
            a.click();

            // Clean up the temporary URL and anchor element
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
    };
    xhr.send();
});
</script>


<script src="script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
