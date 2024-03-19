<?php
try {
$pdo = new
PDO('mysql:host=localhost;port=3306;dbname=utmdb', 'mars','7218934utm');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
$error_message = $e->getMessage();

exit();
}
?>