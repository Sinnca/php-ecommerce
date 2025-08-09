<?php
session_start();
require_once '../config/db.php';

$Email = $_SESSION['Email'];
$Username = $_SESSION['Username']; 
$id = $_SESSION['id'];
$Role = $_SESSION['Role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
        echo "<h1>Hi " . htmlspecialchars($Username) . "</h1>";
    ?>
</body>
</html>