<?php
try {
$pdo = new
PDO('mysql:host=localhost;port=3306;dbname=id21900376_utmdb', '
id21900376_utmdb','keddyDorval@007');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
$error_message = $e->getMessage();

exit();
}
?>