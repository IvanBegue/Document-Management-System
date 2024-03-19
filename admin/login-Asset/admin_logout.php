<?php
session_start();

$_SESSION = array(); 

session_destroy();

header("Location: ../login-Asset/adminlogin.php");
?>



