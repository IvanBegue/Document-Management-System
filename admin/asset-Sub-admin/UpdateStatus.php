<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/MiniProject/db/pdo.php"; // !Load the database configuration file
    $error1=$error2=$error3=$error4='';
    if(isset($_GET['q'])){
        try{

            $stmt=$pdo->prepare("SELECT sb.sub_a_id ,sb.sub_Fname, sb.sub_Lname ,sb.sub_a_pin,sb.sub_a_pwd, d.dept_name  from sub_admin sb , department d where d.dept_id= sb.dept_id  and sb.sub_a_id = :subid");
            $stmt->execute(array(":subid"=>$_GET['subid']));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            

        }catch(Exception $e){
            error_log('Error: ' . $e->getMessage());
            
        }
    }
    
    
    
    
    ?>
    
    
    
    