<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php";
session_start();

$error=$error2="";
$stmt=$pdo->prepare("SELECT CONCAT(s.s_lname,' ' ,s.s_fname) AS fn, s.s_umail,s.s_pin,s.s_mobile,s.s_address,c.cohort_name,p.prog_name,s.s_mode,sch.school_name ,s.year , s.semester FROM student s,cohort c,programme p,school sch where s.cohort_id=c.cohort_id and c.prog_id=p.prog_id and p.school_id=sch.school_id and s.s_id=:id");
    $stmt->execute(array(":id"=>$_SESSION["sid"]));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if(isset($_POST["btnsubmit"])){
        $service = ($_POST["service"]);
        $desc = ($_POST["description"]);
        if(empty($service)){
            $error2="Invalid Option";
        }
        if(empty($desc)){
            $error="Mandatory Filled";
        }
        if(empty($error)&&empty($error2)){
            $sql="INSERT INTO request (req_details,s_id,serv_id) values(:de,:id,:serv_id)";
            $stmt2=$pdo->prepare($sql);
            $stmt2->execute(array(":de"=>$desc,":id"=>$_SESSION["sid"],":serv_id"=>	$service));
            header("location: ../student1/studentIndex.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
</head>
<body>
<?php include_once "../student1/studentDash.php"; ?>
<div class="container">
<form method="POST" >
  <h1 class="form-title">Student Request Form</h1>
      <div class="mb-3">
        <label for="schoolname">School Name</label>
        <input 
        type="text" 
        class="form-control" 
        id="schoolname" 
        placeholder="School" 
        value="<?php echo htmlspecialchars($row["school_name"]) ?>"
        readonly style="font-weight: bold; color: #555;">
      </div>
      
      <div class="main-user-info">  
      <div class="user-input-box">
        <label for="fullName">Full Name</label>
        <input
            type="text" id="fullName" name="fullName" placeholder="Enter Full Name" value="<?php echo htmlspecialchars($row["fn"]) ?>" readonly />
        </div>  
  
        <div class="user-input-box">
          <label for="username">Student ID</label>
          <input
            type="text"
            id="username"
            
            placeholder="Enter Student ID"
            value="<?php echo htmlspecialchars($row["s_pin"]) ?>"
            readonly
          />
        </div>
        <div class="user-input-box">
          <label for="email">Email Address</label>
          <input
            type="email"
            id="email"
            
            placeholder="Enter Umail"
            value="<?php echo htmlspecialchars($row["s_umail"]) ?>"
            readonly
          />
        </div>
        <div class="user-input-box">
          <label for="phoneNumber">Phone Number</label>
          <input
            type="text"
            id="phoneNumber"
            
            placeholder="Enter Phone Number"
            value="<?php echo htmlspecialchars($row["s_mobile"]) ?>"
            readonly
          />
        </div>
        <div class="user-input-box">
          <label for="residentialAddress">Residential Address</label>
          <input
            type="text"
            id="residentialAddress"
            
            placeholder="Enter Address"
            value="<?php echo htmlspecialchars($row["s_address"]) ?>"
            readonly
          />
        </div>
        <div class="user-input-box">
          <label for="programme">Programme</label>
          <input
            type="text"
            id="programme"
            
            placeholder="Programme"
            value="<?php echo htmlspecialchars($row["prog_name"]) ?>"
            readonly
          />
        </div>
          <div class="user-input-box">
          <label for="year">Year</label>
          <input
            type="text"
            id="year"
            
            placeholder="Year"
            value="<?php echo htmlspecialchars($row["year"]) ?>"
            readonly
          />
        </div>
          <div class="user-input-box">
          <label for="mos">Mode of study</label>
          <input
            type="text"
            id="mos"
           
            placeholder="Enter mode of study"
            value="<?php echo htmlspecialchars($row["s_mode"]) ?>"
            readonly
          />
        </div>
      
      <!-- Modify your request select element to include an onchange event -->
      <div class="user-input-box">
        <label for="service">Service</label>
        <select id="service" name="service">
        <option value=""  selected>Select service</option>
        <?php
           $sql1=$pdo->query("select * from service order by serv_name asc");
            foreach($sql1 as $rowservice){
            echo "<option value='".$rowservice['serv_id']."'>".$rowservice['serv_name']."</option>";
            }
        ?>
        
        </select>
        <span class="text-danger"><?php echo $error2 ?></span>
    </div>
        <div class="user-input-box">
          <label for="cohort">Cohort</label>
          <input
            type="text"
            id="cohort"
           
            placeholder="Cohort"
            value="<?php echo htmlspecialchars($row["cohort_name"]) ?>"
            readonly
          />
        </div>
          <!-- Add a label for date with sysdate (current date) -->
          <?php $today = date("d-m-Y ");  ?>
          <div class="user-input-box">
            <label for="date">Date</label>
            <input
                type="text"

                value="<?php echo $today?>"
                readonly
            />
        </div>
        
        <div class="user-input-box">
            <label for="semester">Semester</label>
            <input
            type="text"
            id="semester"
            
            placeholder="semester"
            value="<?php echo htmlspecialchars($row["semester"]) ?>"
            readonly
          />
        </div>

          
          <!--<div class="user-input-box">
            <label for="filecover" class="form-label">Upload Images</label>
            <div class="file-upload-container">
                <input class="form-control form-control-lg" id="filecover" name="filecover" type="file" multiple>
                <div id="selected-files" class="selected-files"></div>
            </div>
        </div> -->
        
        <!--<div class="user-input-box">
          <label for="captcha">Please enter the code below:</label>
          
          <input type="text" id="captcha-input" placeholder="Enter the code">
          <br>
          <br>
          <span class="captcha-code" id="captcha-code">AB12CD</span>
          <span class="refresh-button" id="refresh-captcha">Refresh</span>
          <buttons onclick="validateCaptcha()">&#10003;</buttons>

      </div>-->
    <?php 
    if(!empty($error)){
        echo'<div class="input-group">';
        echo '<label for="description" class="input-label">Detail of request</label>';
        echo '<textarea class="form-control border border-danger border-3" id="description" name="description" placeholder="Enter Details of request" aria-label="With textarea"></textarea>';
        echo '<span class="text-danger m-3">';
        echo $error ;
        echo '</span>';
        echo '</div>';
    }else{
        echo'<div class="input-group">';
        echo '<label for="description" class="input-label">Detail of request</label>';
        echo '<textarea class="form-control " id="description" name="description" placeholder="Enter Details of request" aria-label="With textarea"></textarea>';
    
        echo '</div>';
    }
    ?>
    <div class="d-grid gap-2 d-md-block">
        <button type="submit" name="btnsubmit" class="btn btn-primary">Submit</button>
        <a href="../student1/studentIndex.php"class="btn btn-primary">Back Home</a>
    </div>
        
    </form>
</body>
</html>