<?php
session_start();
if(!isset($_SESSION['login'])){
    header("location:index.php");
    exit();
}

include "./db/base.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理中心</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php
    include "./layout/header.php";
?>



 
<?php
$do=$_GET['do']??'main';
$file='./back/'.$do.".php";

if(file_exists($file)){
    include $file;
}else{
    include "./back/main.php";
}
?>
    
</body>
</html>