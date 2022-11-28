<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生管理系統</title>
    <link rel="stylesheet" href="style.css">
    <?php include "./layout/link_css.php";?>
</head>
<body>
<?php
    include "./layout/header.php";

    $do = $_GET['do'] ?? 'main';
    $file = "./front/" . $do . ".php";

    if(file_exists($file)){
        include $file;
    }else{
        include "./front/main.php";
    }

    include "./layout/scripts.php";
?>
</body>
</html>